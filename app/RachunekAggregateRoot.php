<?php


namespace App;

use App\Events\BlokadaSrodkow;
use App\Events\OdblokowanieSrodkow;
use App\Events\PrzelewPrzychodzacy;
use App\Events\PrzelewWychodzacy;
use App\Events\StworzenieRachunku;
use App\Events\WplataPieniedzy;
use App\Events\WykonanieTransakcji;
use App\Events\WyplataPieniedzy;
use App\Exceptions\BrakWystarczajacychSrodkow;
use App\Exceptions\PrzekroczonoLimitDzienny;
use App\Exceptions\PrzekroczonoLimitMiesieczny;
use Spatie\EventSourcing\AggregateRoot;

/**
 * Class RachunekAggregateRoot
 *
 * Agregat rachunku. Przy wywołaniu metody "retrieve", zbiera wszystkie eventy
 * przypisane do id (uuid) danego rachunku i wywołuje metody z prefixem apply odpowiadające każdemu z nich.
 * W ten sposób atrybuty klasy są wypełniane wartościami i możemy z nich korzystać przy wykonywaniu kolejnych operacji.
 *
 * Ta klasa odpowiada również za wywołanie Eventów które następnie są przetwarzane przez RachunekProjector.php w celu
 * uzupełnienia danych w odpowiednich tabelach.
 *
 */
class RachunekAggregateRoot extends AggregateRoot
{

    /**
     * @var float
     */
    public $saldo = .0;

    /**
     * @var float
     */
    public $srodkiZablokowane;

    /**
     * @var string
     */
    public $nrRachunku;

    /**
     * @var float
     */
    public $dzisiajWydano = .0;

    /**
     * @var float
     */
    public $wTymMiesiacuWydano = .0;

    public function __construct()
    {
        $this->srodkiZablokowane = collect();
    }

    /**
     * @return float
     */
    public function dostepneSrodki()
    {
        return $this->saldo - $this->srodkiZablokowane->sum();
    }

    /**
     * @param  float  $kwota
     *
     * @return bool
     */
    private function posiadaWiecejNiz(float $kwota): bool
    {
        return $this->dostepneSrodki() - $kwota >= 0;
    }

    /**
     * Zwraca swieza wersje agregatu bazujac tylko na eventach przechowanych w bazie danych
     *
     * @return RachunekAggregateRoot
     */
    public function fresh(): self
    {
        return Rachunek::numer($this->nrRachunku)->getAggregate();
    }


    /**
     * Dopisz kwote do wydatkow dziennych i miesiecznych
     *
     * @param  WykonanieTransakcji  $event
     */
    private function zarejestrujWydatek(WykonanieTransakcji $event): void
    {
        if ($event->getCreatedAt()->isToday()) {
            $this->dzisiajWydano += $event->kwota;
        }

        if ($event->getCreatedAt()->isCurrentMonth()) {
            $this->wTymMiesiacuWydano += $event->kwota;
        }
    }

    /**
     * @param  float  $kwota
     *
     * @throws BrakWystarczajacychSrodkow
     * @throws PrzekroczonoLimitDzienny|PrzekroczonoLimitMiesieczny
     */
    private function sprawdzMozliwoscWykonaniaTransakcji(float $kwota): void
    {
        if (!$this->posiadaWiecejNiz($kwota)) {
            throw new BrakWystarczajacychSrodkow("Dostępne środki: {$this->dostepneSrodki()} Kwota: $kwota");
        }

        if (auth()->check()) {
            if (auth()->user()->klient->limit_dzienny <= ($this->dzisiajWydano + $kwota)) {
                throw new PrzekroczonoLimitDzienny('Przekroczenie dziennego limitu wydatkow.');
            }

            if (auth()->user()->klient->ustawienie_budzetu <= ($this->wTymMiesiacuWydano  + $kwota)) {
                throw new PrzekroczonoLimitMiesieczny('Przekroczenie miesiecznego limitu wydatkow.');
            }
        }
    }

    /**
     * @param  string  $idKlienta
     * @param  string  $numerRachunku
     *
     * @return $this
     */
    public function utworzRachunekKlienta(string $idKlienta, string $numerRachunku): self
    {
        $this->recordThat(new StworzenieRachunku($idKlienta, $numerRachunku));

        return $this;
    }

    /**
     * @param  StworzenieRachunku  $event
     */
    protected function applyStworzenieRachunku(StworzenieRachunku $event): void
    {
        $this->nrRachunku = $event->numerRachunku;
    }

    /**
     * @param  float  $kwota
     *
     * @return RachunekAggregateRoot
     * @throws BrakWystarczajacychSrodkow|PrzekroczonoLimitDzienny|PrzekroczonoLimitMiesieczny
     */
    public function zablokujSrodki(float $kwota): self
    {
        $this->sprawdzMozliwoscWykonaniaTransakcji($kwota);

        $this->recordThat(new BlokadaSrodkow($kwota));

        return $this;
    }

    /**
     * @param  BlokadaSrodkow  $event
     */
    protected function applyBlokadaSrodkow(BlokadaSrodkow $event): void
    {
        $this->srodkiZablokowane->push($event->kwota);
    }

    /**
     * @param  float   $kwota
     *
     * @param  string  $wiadomosc
     *
     * @return RachunekAggregateRoot
     */
    public function odblokujSrodki(float $kwota, string $wiadomosc = ''): self
    {
        $this->recordThat(new OdblokowanieSrodkow($kwota, $wiadomosc));

        return $this;
    }

    /**
     * @param  OdblokowanieSrodkow  $event
     */
    protected function applyOdblokowanieSrodkow(OdblokowanieSrodkow $event): void
    {
        $this->srodkiZablokowane = $this->srodkiZablokowane->reject(function ($kwota) use ($event) {
            return $event->kwota === $kwota;
        });
    }

    /**
     * @param  float  $kwota
     *
     * @return $this
     */
    public function wplac(float $kwota): self
    {
        $this->recordThat(new WplataPieniedzy($kwota));

        return $this;
    }

    /**
     * @param  WplataPieniedzy  $event
     */
    protected function applyWplataPieniedzy(WplataPieniedzy $event): void
    {
        $this->saldo += $event->kwota;
    }

    /**
     * @param  float  $kwota
     *
     * @return $this
     * @throws BrakWystarczajacychSrodkow
     * @throws PrzekroczonoLimitDzienny|PrzekroczonoLimitMiesieczny
     */
    public function wyplac(float $kwota): self
    {
        $this->sprawdzMozliwoscWykonaniaTransakcji($kwota);

        $this->recordThat(new WyplataPieniedzy($kwota));

        return $this;
    }

    /**
     * @param  WyplataPieniedzy  $event
     */
    protected function applyWyplataPieniedzy(WyplataPieniedzy $event): void
    {
        $this->saldo -= $event->kwota;

        $this->zarejestrujWydatek($event);
    }

    /**
     * @param  Transakcja  $transakcja
     *
     * @return RachunekAggregateRoot
     * @throws BrakWystarczajacychSrodkow
     */
    public function przelewWychodzacy(Transakcja $transakcja): self
    {
        $this->recordThat(new PrzelewWychodzacy(
            $transakcja->nr_rachunku_powiazanego,
            $transakcja->tytul,
            $transakcja->kwota, $transakcja->odbiorca
        ));

        return $this;
    }

    /**
     * @param  PrzelewWychodzacy  $event
     */
    protected function applyPrzelewWychodzacy(PrzelewWychodzacy $event): void
    {
        $this->saldo             -= $event->kwota;
        $this->srodkiZablokowane = $this->srodkiZablokowane->reject(function ($kwota) use ($event) {
            return $event->kwota === $kwota;
        });

        $this->zarejestrujWydatek($event);
    }


    /**
     * @param  Transakcja  $transakcja
     *
     * @return RachunekAggregateRoot
     */
    public function przelewPrzychodzacy(Transakcja $transakcja): self
    {
        $this->recordThat(new PrzelewPrzychodzacy(
            $transakcja->nr_rachunku,
            $transakcja->tytul,
            $transakcja->kwota
        ));

        return $this;
    }

    /**
     * @param  PrzelewPrzychodzacy  $event
     */
    protected function applyPrzelewPrzychodzacy(PrzelewPrzychodzacy $event): void
    {
        $this->saldo += $event->kwota;
    }
}
