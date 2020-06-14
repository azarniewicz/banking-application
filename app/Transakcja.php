<?php

namespace App;

use App\Events\PrzelewPrzychodzacy;
use App\Events\PrzelewWychodzacy;
use App\Events\WplataPieniedzy;
use App\Events\WyplataPieniedzy;
use App\Exceptions\NieznanyTypTransakcji;
use App\Jobs\WykonajTransakcje;
use Hashids\Hashids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 *
 * @property int    $id
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

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $casts = [
        'data_wykonania' => 'datetime'
    ];

    /**
     * Instancja głównej klasy biblioteki przekształcającej liczby na hashe
     *
     * @var Hashids
     */
    private $hashid;

    /**
     * Transakcja constructor.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->hashid = new Hashids(config('app.salt'), 4);
        parent::__construct($attributes);
    }

    /**
     * Zwraca czytelną dla użytkownika nazwę eventu.
     *
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
     * Zwraca true jeżeli transakcja była przelewem środków
     *
     * @return bool
     */
    public function isPrzelew()
    {
        return str_contains($this->typ, 'Przelew');
    }

    /**
     * Zwraca id transakcji w formie hasha
     *
     * @return string
     */
    public function getNrTransakcjiAttribute()
    {
        return $this->hashid->encode($this->id);
    }

    /**
     * Zwraca rachunek płatnika transakcji
     *
     * @return BelongsTo
     */
    public function rachunek_platnika()
    {
        $foreign = $this->typ === 'Przelew wychodzący' ? 'nr_rachunku' : 'nr_rachunku_powiazanego';
        return $this->belongsTo(Rachunek::class, $foreign, 'nr_rachunku');
    }

    /**
     *
     * Zwraca rachunek odbiorcy transakcji
     *
     * @return BelongsTo
     */
    public function rachunek_odbiorcy()
    {
        $foreign = $this->typ === 'Przelew wychodzący' ? 'nr_rachunku_powiazanego' : 'nr_rachunku';
        return $this->belongsTo(Rachunek::class, $foreign, 'nr_rachunku');
    }

    /**
     * Metoda wytworcza ( factory method ) dla transakcji.
     * Zwraca odpowiednia klase z podanymi atrybutami bazując na podanym typie transakcji
     *
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
