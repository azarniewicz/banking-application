<?php

namespace App\Projectors;

use App\Events\Przelew;
use App\Events\StworzenieRachunku;
use App\Events\WplataPieniedzy;
use App\Events\WyplataPieniedzy;
use App\Rachunek;
use Illuminate\Support\Facades\DB;
use Spatie\EventSourcing\Facades\Projectionist;
use Spatie\EventSourcing\Projectors\Projector;
use Spatie\EventSourcing\Projectors\ProjectsEvents;
use Spatie\EventSourcing\StoredEvent;
use Spatie\EventSourcing\StoredEventRepository;

class RachunekProjector implements Projector
{
    use ProjectsEvents;

    /**
     * @param  StworzenieRachunku  $event
     * @param  string              $aggregateUuid
     */
    public function onRachunekCreated(StworzenieRachunku $event, string $aggregateUuid): void
    {
        Rachunek::create([
            'uuid'        => $aggregateUuid,
            'nr_rachunku' => $event->numerRachunku
        ])->klienci()->attach($event->idKlienta);
    }

    /**
     * @param  WplataPieniedzy  $event
     * @param  string           $aggregateUuid
     * @param  StoredEvent      $storedEvent
     */
    public function onWplataPieniedzy(WplataPieniedzy $event, StoredEvent $storedEvent, string $aggregateUuid): void
    {
        $rachunek = Rachunek::uuid($aggregateUuid);

        $rachunek->dodajDoSalda($event->kwota);

        $this->zapiszSaldoPoTransakcji($storedEvent, $rachunek);
    }

    /**
     * @param  WyplataPieniedzy  $event
     * @param  string            $aggregateUuid
     */
    public function onWyplataPieniedzy(WyplataPieniedzy $event, StoredEvent $storedEvent, string $aggregateUuid): void
    {
        $rachunek = Rachunek::uuid($aggregateUuid);

        $rachunek->odejmijZSalda($event->kwota);

        $this->zapiszSaldoPoTransakcji($storedEvent, $rachunek);
    }

    /**
     * @param  Przelew  $event
     * @param  string   $aggregateUuid
     */
    public function onPrzelew(Przelew $event, StoredEvent $storedEvent, string $aggregateUuid): void
    {
        $rachunek = Rachunek::uuid($aggregateUuid);

        // TODO tylko przelewy wewnetrzne?
        $rachunekDocelowy = Rachunek::numer($event->nrRachunkuDocelowego);

        DB::beginTransaction();
        $rachunek->odejmijZSalda($event->kwota);
        $rachunekDocelowy->dodajDoSalda($event->kwota);
        DB::commit();

        $this->zapiszSaldoPoTransakcji($storedEvent, $rachunek, $rachunekDocelowy);
    }

    /**
     * @param  StoredEvent    $storedEvent
     * @param  Rachunek       $rachunek
     * @param  Rachunek|null  $rachunekDocelowy
     */
    private function zapiszSaldoPoTransakcji(StoredEvent $storedEvent,
                                             Rachunek $rachunek,
                                             Rachunek $rachunekDocelowy = null): void
    {
        if (!Projectionist::isReplaying()) {
            $storedEvent->meta_data['saldo_po_transakcji'] = $rachunek->saldo;
            if ($rachunekDocelowy) {
                $storedEvent->meta_data['saldo_rachunku_docelowego_po_transakcji'] = $rachunekDocelowy->saldo;
            }
            (resolve(StoredEventRepository::class))->update($storedEvent);
        }
    }
}
