<?php


namespace App;

use App\Domain\Account\Events\AccountCreated;
use App\Events\BlokadaSrodkow;
use App\Events\OdblokowanieSrodkow;
use App\Events\PrzelewPrzychodzacy;
use App\Events\PrzelewWychodzacy;
use App\Events\StworzenieRachunku;
use App\Events\WplataPieniedzy;
use App\Events\WyplataPieniedzy;
use App\Exceptions\BrakWystarczajacychSrodkow;
use Spatie\EventSourcing\AggregateRoot;

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
     * @throws BrakWystarczajacychSrodkow
     */
    public function zablokujSrodki(float $kwota): self
    {
        if (!$this->posiadaWiecejNiz($kwota)) {
            throw new BrakWystarczajacychSrodkow(
                'Dostępne środki: ' . $this->dostepneSrodki() . " Kwota do przelania: $kwota"
            );
        }

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
     */
    public function wyplac(float $kwota): self
    {
        if (!$this->posiadaWiecejNiz($kwota)) {
            throw new BrakWystarczajacychSrodkow("Saldo: $this->saldo Kwota do wyplaty: $kwota");
        }

        $this->recordThat(new WyplataPieniedzy($kwota));

        return $this;
    }

    /**
     * @param  WyplataPieniedzy  $event
     */
    protected function applyWyplataPieniedzy(WyplataPieniedzy $event): void
    {
        $this->saldo -= $event->kwota;
    }

    /**
     * @param  Transakcja  $transakcja
     *
     * @return RachunekAggregateRoot
     * @throws BrakWystarczajacychSrodkow
     */
    public function przelewWychodzacy(Transakcja $transakcja): self
    {
        if (!$this->posiadaWiecejNiz($transakcja->kwota)) {
            throw new BrakWystarczajacychSrodkow("Saldo: $this->saldo Kwota do przelania: $transakcja->kwota");
        }

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
