<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KartaKredytowa extends Model
{
    /**
     * @var string
     */
    protected $table = 'karty_kredytowe';

    protected $guarded = ['id'];
}
