<?php


namespace App;

use App\Domain\Account\Events\AccountCreated;
use App\Events\Przelew;
use App\Events\StworzenieRachunku;
use App\Events\WplataPieniedzy;
use App\Events\WyplataPieniedzy;
use App\Exceptions\BrakWystarczajacychSrodkow;
use App\Exceptions\PrzelewNaTenSamRachunek;
use App\Exceptions\RachunekNieIstnieje;
use Spatie\EventSourcing\AggregateRoot;

class RachunekAggregateRoot extends AggregateRoot
{

    /**
     * @var float
     */
    public $saldo = .0;

    /**
     * @var string
     */
    public $nrRachunku;

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
        if (!$this->posiadaWystarczajaceSrodki($kwota)) {
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
     * @param  string  $nrRachunku
     * @param  string  $tytul
     * @param  float   $kwota
     *
     * @return $this
     * @throws BrakWystarczajacychSrodkow
     * @throws PrzelewNaTenSamRachunek|RachunekNieIstnieje
     */
    public function przelej(string $nrRachunku, string $tytul, float $kwota): self
    {
        if (!$this->posiadaWystarczajaceSrodki($kwota)) {
            throw new BrakWystarczajacychSrodkow("Saldo: $this->saldo Kwota do przelania: $kwota");
        }

        if ($this->nrRachunku === $nrRachunku) {
            throw new PrzelewNaTenSamRachunek();
        }

        if (null === Rachunek::numer($nrRachunku)) {
            throw new RachunekNieIstnieje("Rachunek z numerem $nrRachunku nie zostal znaleziony");
        }

        $this->recordThat(new Przelew($nrRachunku, $tytul, $kwota));

        return $this;
    }

    /**
     * @param  Przelew  $event
     */
    protected function applyPrzelew(Przelew $event): void
    {
        $this->saldo -= $event->kwota;
    }

    /**
     * @param  float  $kwota
     *
     * @return bool
     */
    private function posiadaWystarczajaceSrodki(float $kwota): bool
    {
        return $this->saldo - $kwota >= 0;
    }
}
