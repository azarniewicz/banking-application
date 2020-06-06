<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Klient extends User
{
    use \Parental\HasParent;

    protected $table = 'klienci';

    public function rachunki()
    {

        return $this->belongsToMany(
            Rachunek::class,
            'klient_rachunek',
            'id_uzytkownika',
            'id_rachunku'
        );
    }

    public function getRachunekAttribute()
    {
        return $this->rachunki->first();
    }

    public function klient()
    {
        return $this->hasOne(Klient::class, 'id_uzytkownika');
    }
}
