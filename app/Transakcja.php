<?php

namespace App;

use App\Events\PrzelewPrzychodzacy;
use App\Events\PrzelewWychodzacy;
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
 * @property string $nr_rachunku
 * @property string $typ
 * @property string $nr_rachunku_powiazanego
 * @property float  $kwota
 * @property string $tytul
 * @property string $odbiorca
 * @property Carbon $data_zlecenia
 * @property Carbon $data_wykonania
 */
class Transakcja extends Model
{
    public const ekspres = 'ekspres';

    public const standard = 'standard';

    public const planowana = 'planowana';

    /**
     * @var string
     */
    protected $table = 'transakcje';

    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [
        'data_wykonania' => 'datetime'
    ];

    /**
     * @param  string  $eventClassName
     *
     * @return string
     */
    public static function nazwaTransakcji(string $eventClassName): ?string
    {
        switch ($eventClassName) {
            case PrzelewPrzychodzacy::class:
                return 'Przelew przychodzący';
            case PrzelewWychodzacy::class:
                return 'Przelew wychodzący';
            case WplataPieniedzy::class:
                return 'Wpłata';
            case WyplataPieniedzy::class:
                return 'Wypłata';
            default:
                return $eventClassName;
        }
    }

    /**
     * @return bool
     */
    public function isPrzelew()
    {
        return str_contains($this->typ, 'Przelew');
    }

    public function rachunek_platnika()
    {
        $foreign = $this->typ === 'Przelew wychodzący' ? 'nr_rachunku' :  'nr_rachunku_powiazanego';
        return $this->belongsTo(Rachunek::class, $foreign, 'nr_rachunku');
    }

    public function rachunek_odbiorcy()
    {
        $foreign = $this->typ === 'Przelew wychodzący' ? 'nr_rachunku_powiazanego' : 'nr_rachunku' ;
        return $this->belongsTo(Rachunek::class, $foreign, 'nr_rachunku');
    }

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
            case self::planowana:
                return TransakcjaPlanowana::make($attributes);
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
