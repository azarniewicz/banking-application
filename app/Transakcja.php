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

    /**
     * @param $value
     *
     * @return string
     */
    public function getTypAttribute($value): ?string
    {
        switch ($value) {
            case Przelew::class:
                return 'Przelew wychodzący';
            case WplataPieniedzy::class:
                return 'Wpłata';
            case WyplataPieniedzy::class:
                return 'Wypłata';
            default:
                return $value;
        }
    }
}
