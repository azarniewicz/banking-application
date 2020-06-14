<?php

namespace App;

use Faker\Provider\pl_PL\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Klient extends User
{
    use \Parental\HasParent;

    /**
     * @var string
     */
    protected $table = 'klienci';

    /**
     * @var string[]
     */
    protected $fillable = [
        'nr_dowodu', 'nr_telefonu', 'miasto', 'ulica_nr', 'kod_pocztowy',
        'limit_dzienny', 'ustawienie_budzetu','pesel'
    ];

    /**
     * @return BelongsToMany
     */
    public function rachunki()
    {
        return $this->belongsToMany(
            Rachunek::class,
            'klient_rachunek',
            'id_uzytkownika',
            'id_rachunku'
        );
    }

    /**
     * @return mixed
     */
    public function getRachunekAttribute()
    {
        return $this->rachunki->first();
    }

    /**
     * @return HasOne
     */
    public function uzytkownik(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'id_uzytkownika');
    }

    /**
     * @return HasMany
     */
    public function stali_odbiorcy()
    {
        return $this->hasMany(StalyOdbiorca::class, 'id_klienta', 'id');
    }
}
