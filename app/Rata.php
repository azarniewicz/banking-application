<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Rata extends Model
{
    protected $table = 'raty';
    protected $fillable = [
        'cena',
        'status',
        'id_transakcji',
        'id_kredytu'
    ];
    protected $primaryKey = 'id_raty';

    private function getKwotaDoOddania(float $kwota,int $iloscRat) : float{
        $aktualneOprocentowanie = Kredyt::AKTUALNE_OPROCENTOWANIE;
        $wynikDolny = 0;
        for($i = 1; $i <= $iloscRat; $i ++){
            $wynikDolny = $wynikDolny + (1 / pow((1 + ($aktualneOprocentowanie / 12)),$i));
        }
        return (float) ($kwota / $wynikDolny);
    }
    private function getTerminZaplaty($ile){
        return Carbon::now()->addMonth($ile)->startOfMonth();
    }
    private function getDataToInsert($kwotaDoOddania,$iloscRat,$idKredytu) : array {
        $data = [];
        for($i = 1; $i <= $iloscRat; $i ++){
            $terminZaplaty = $this->getTerminZaplaty($i);
            $data[] = [
                'cena'=>$kwotaDoOddania,
                'status'=>'NIEOPŁACONA',
                'id_kredytu'=>$idKredytu,
                'termin_zaplaty'=>$terminZaplaty
            ];
        }
        return $data;
    }
    public function zaplac($rachunekAggregateRoot){
        $base = $rachunekAggregateRoot->przelewWychodzacy(new Transakcja([
            'kwota' => $this->cena,
            'nr_rachunku_powiazanego'=>Rachunek::NR_RACHUNKU_BANKU,
            'tytul'=>'SPŁATA KREDYTU',
            'odbiorca'=>'BANK',
        ]))->persist();
        $this->status = 'OPŁACONA';
        $this->id_transakcji = Transakcja::orderByDesc('id')->first()->id;
        $this->save();
        return $this;
    }
    public function kredyt(){
        return $this
            ->join('kredyty','raty.id_kredytu','=','kredyty.id_kredytu');
    }
    public function getAktualnaRata($klientId){
        return $this
            ->kredyt()
            ->where('status','NIEOPŁACONA')
            ->where('kredyty.id_klienta',$klientId)
            ->orderBy('termin_zaplaty')
            ->first();
    }
    public function getPozostalaKwota($klientId){
        return $this->kredyt()
            ->where('status','NIEOPŁACONA')
            ->where('kredyty.id_klienta',$klientId)
            ->sum('cena');
    }
    public function getPozostaloRat($klientId){
        return $this
            ->kredyt()
            ->where('kredyty.id_klienta',$klientId)
            ->where('status','NIEOPŁACONA')
            ->count();
    }
    public function getPoprzednieRatyKlienta($klientId){
        return $this
           ->kredyt()
            ->select('id_raty','termin_zaplaty','cena','data_wykonania')
            ->join('transakcje','raty.id_transakcji','=','transakcje.id')
            ->where('kredyty.id_klienta',$klientId)
            ->where('status','OPŁACONA')
            ->orderByDesc('termin_zaplaty')
            ->get();
    }
    public function store(float $kwota,int $iloscRat,int $idKredytu) : self{
        $kwotaDoOddania = $this->getKwotaDoOddania($kwota,$iloscRat);
        $data = $this->getDataToInsert($kwotaDoOddania,$iloscRat,$idKredytu);
        $this->insert($data);
        return $this;
    }
}
