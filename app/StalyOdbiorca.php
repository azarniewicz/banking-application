<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StalyOdbiorca extends Model
{
    protected $table = 'stali_odbiorcy';
    protected $fillable = ['nazwa','nr_rachunku','nazwa_adres','id_klienta'];
    protected $primaryKey = 'id_odbiorcy';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($stalyOdbiorca) {
            $stalyOdbiorca->nr_rachunku = str_replace(" ", '', $stalyOdbiorca->nr_rachunku);
        });
    }
}
