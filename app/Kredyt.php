<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Kredyt extends Model
{

    protected $table = 'kredyty';
    protected $fillable = [
        'id_klienta',
        'data_wniosku',
        'data_zakonczenia_wniosku',
        'kwota_kredytu',
        'oprocentowanie',
        'zgoda_odmowa',
        'ilosc_rat'
    ];

    protected $primaryKey = 'id_kredytu';

    const AKTUALNE_OPROCENTOWANIE = 0.05;

    public function getWnioski(){
        return $this
            ->select('*','kredyty.id_kredytu')
            ->whereNull('zgoda_odmowa')
            ->join('klienci','kredyty.id_klienta','=','klienci.id')
            ->join('uzytkownicy','klienci.id_uzytkownika','=','uzytkownicy.id')
                ->orderByDesc('data_wniosku');
    }

    private function setDataWniosku() : self{
        $this->data_wniosku = Carbon::now();
        return $this;
    }
    private function setDataZakonczeniaWniosku() : self{
        $this->data_zakonczenia_wniosku = Carbon::now();
        return $this;
    }
    public function setOdmowa() : self {
        $this->zgoda_odmowa = 'ODMOWA';
        $this->setDataZakonczeniaWniosku();
        $this->update();
        return $this;
    }
    public function przelejGotowke($rachunekAggregateRoot){
        $rachunekAggregateRoot->przelewPrzychodzacy(new Transakcja([
            'nr_rachunku' => Rachunek::NR_RACHUNKU_BANKU,
            'tytul' => 'Kredyt',
            'kwota' => $this->kwota_kredytu
        ]))->persist();
    }
    public function setZgoda() : self{
        $this->zgoda_odmowa = 'ZGODA';
        $this->setDataZakonczeniaWniosku();
        $this->update();

        return $this;
    }
    public function setWniosek(array $data,int $idKlienta): self {
        $this->id_klienta = $idKlienta;
        $this->kwota_kredytu = $data['kwota_kredytu'];
        $this->ilosc_rat = $data['ilosc_rat'];
        $this->oprocentowanie = self::AKTUALNE_OPROCENTOWANIE;
        $this->setDataWniosku();
        $this->save();
        return $this;
    }
}
