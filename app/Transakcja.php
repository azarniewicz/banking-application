<?php

namespace App;

use App\Events\WplataPieniedzy;
use App\Events\WyplataPieniedzy;
use App\Exceptions\NieznanyTypTransakcji;
use App\Jobs\WykonajTransakcje;
use Illuminate\Database\Eloquent\Model;
use App\Events\Przelew;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Carbon;

/**
 *
 * @property string $id_rachunku
 * @property string $typ
 * @property string $nr_rachunku_powiazanego
 * @property float  $kwota
 * @property string $tytul
 * @property string $odbiorca
 * @property Carbon $data
 */
class Transakcja extends Model
{
    public const ekspres = 'ekspres';

    public const standard = 'standard';

    /**
     * @var string
     */
    protected $table = 'transakcje';

    public $timestamps = false;

    protected $guarded = ['id'];

    /**
     * @param  array   $attributes
     * @param  string  $typ
     *
     * @return mixed
     * @throws NieznanyTypTransakcji
     */
    public static function makeFrom(array $attributes, string $typ)
    {
        switch ($typ) {
            case self::standard:
                return self::make($attributes);
            case self::ekspres:
                return TransakcjaEkspresowa::make($attributes);
        }

        throw new NieznanyTypTransakcji('System nie obsługuje podanego typu transakcji: ' . $typ);
    }

    /**
     * Zleć wykonanie transakcji
     */
    public function wykonaj()
    {
        WykonajTransakcje::dispatch($this);
    }
}
