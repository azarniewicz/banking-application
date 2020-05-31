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
     * @var array
     */
    public $guarded = [];

    public function transakcje()
    {
        return $this->hasMany(Transakcja::class, 'nr_rachunku', 'nr_rachunku');
    }

    public function klienci()
    {
        return $this->belongsToMany(Klient::class);
    }

    /**
     * @param  string  $uuid
     *
     * @return static
     */
    public static function uuid(string $uuid): self
    {
        return static::where('uuid', $uuid)->first();
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
