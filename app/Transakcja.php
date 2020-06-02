<?php

namespace App;

use App\Events\WplataPieniedzy;
use App\Events\WyplataPieniedzy;
use Illuminate\Database\Eloquent\Model;
use App\Events\Przelew;
use Illuminate\Support\Carbon;

/**
 *
 * @property string $nr_rachunku
 * @property string $typ
 * @property string $nr_rachunku_powiazanego
 * @property float  $kwota
 * @property string $tytul_przelewu
 * @property Carbon $data
 */
class Transakcja extends Model
{
    /**
     * @var string
     */
    protected $table = 'transakcje';

    public $timestamps = false;

    protected $guarded = ['id'];
}
