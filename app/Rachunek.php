<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rachunek extends Model
{

    const NR_RACHUNKU_BANKU = 'PL2132131231231231231';
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
     * @return float
     */
    public function getDostepneSrodkiAttribute(): float
    {
        return $this->getAggregate()->dostepneSrodki();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transakcje()
    {
        return $this->hasMany(Transakcja::class, 'nr_rachunku', 'nr_rachunku');
    }

    /**
     * @return BelongsToMany
     */
    public function klienci()
    {
        return $this->belongsToMany(Klient::class, 'klient_rachunek', 'id_rachunku', 'id_uzytkownika');
    }

    /**
     * @return mixed|null
     */
    public function getKlientAttribute()
    {
        return $this->klienci()->first();
    }

    /**
     * @return mixed
     */
    public function uzytkownik()
    {
        return $this->klient->uzytkownik();
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
     * Zwraca agregate rachunku
     *
     * @return RachunekAggregateRoot
     */
    public function getAggregate(): RachunekAggregateRoot
    {
        return RachunekAggregateRoot::retrieve($this->id);
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

    public function scopeDostepneDoPrzelewow()
    {
        return self::whereHas('klienci', function ($query) {
            $query->where('klient_rachunek.id_uzytkownika', '!=', auth()->user()->id);
        });
    }
}
