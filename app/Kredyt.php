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

    const AKTUALNE_OPROCENTOWANIE = 0.05;

    private function setDataWniosku() : self{
        $this->data_wniosku = Carbon::now();
        return $this;
    }
    private function setDataZakonczeniaWniosku() : self{
        $this->data_zakonczenia_wniosku = Carbon::now();
        return $this;
    }
    public function setOdmowa() : self {
        $this->zgodaodmowa = 'ODMOWA';
        $this->setDataZakonczeniaWniosku();
        $this->update();
        return $this;
    }
    public function setZgoda() : self{
        $this->zgodaodmowa = 'ZGODA';
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
