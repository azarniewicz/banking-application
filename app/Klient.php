<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Klient extends User
{
    use \Parental\HasParent;

    protected $table = 'klienci';

    protected $fillable = [
        'nr_dowodu', 'nr_telefonu', 'miasto', 'ulica_nr', 'kod_pocztowy',
        'limit_dzienny', 'ustawienie_budzetu'
    ];

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

    public function uzytkownik()
    {
        return $this->hasOne(User::class, 'id', 'id_uzytkownika');
    }
}
