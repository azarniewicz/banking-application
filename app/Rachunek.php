<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rachunek extends Model
{
    /**
     * @var string
     */
    protected $table = 'rachunki';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    public $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transakcje()
    {
        return $this->hasMany(Transakcja::class, 'id_rachunku');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function klienci()
    {
        return $this->belongsToMany(Klient::class, 'klient_rachunek', 'id_rachunku', 'id_uzytkownika');
    }

    /**
     * @param  string  $uuid
     *
     * @return static
     */
    public static function uuid(string $uuid): self
    {
        return static::where('id', $uuid)->first();
    }

    /**
     * @param  string  $nrRachunkuDocelowego
     *
     * @return mixed
     */
    public static function numer(string $nrRachunkuDocelowego)
    {
        return static::where('nr_rachunku', $nrRachunkuDocelowego)->first();
    }

    /**
     * @param  float  $kwota
     */
    public function dodajDoSalda(float $kwota): void
    {
        $this->update(['saldo' => $this->saldo += $kwota]);
    }

    /**
     * @param  float  $kwota
     */
    public function odejmijZSalda(float $kwota)
    {
        $this->update(['saldo' => $this->saldo -= $kwota]);
    }
}
