<?php

namespace App\Projectors;

use App\Events\PrzelewPrzychodzacy;
use App\Events\PrzelewWychodzacy;
use App\Events\StworzenieRachunku;
use App\Events\TransakcjaZakonczona;
use App\Events\WplataPieniedzy;
use App\Events\WyplataPieniedzy;
use App\Rachunek;
use App\Transakcja;
use Spatie\EventSourcing\Projectors\Projector;
use Spatie\EventSourcing\Projectors\ProjectsEvents;
use Spatie\EventSourcing\StoredEvent;

class RachunekProjector implements Projector
{
    use ProjectsEvents;

    /**
     * Wywolywana przy starcie odtwarzania eventow
     */
    public function onStartingEventReplay()
    {
        Transakcja::truncate();
        Rachunek::truncate();
    }

    /**
     * @param  StworzenieRachunku  $event
     * @param  string              $aggregateUuid
     */
    public function onRachunekCreated(StworzenieRachunku $event, string $aggregateUuid): void
    {
        Rachunek::create([
            'id' => $aggregateUuid,
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
        $rachunek = Rachunek::find($aggregateUuid);

        $rachunek->dodajDoSalda($event->kwota);

        event(new TransakcjaZakonczona($storedEvent, $rachunek));
    }

    /**
     * @param  WyplataPieniedzy  $event
     * @param  StoredEvent       $storedEvent
     * @param  string            $aggregateUuid
     */
    public function onWyplataPieniedzy(WyplataPieniedzy $event, StoredEvent $storedEvent, string $aggregateUuid): void
    {
        $rachunek = Rachunek::find($aggregateUuid);

        $rachunek->odejmijZSalda($event->kwota);

        event(new TransakcjaZakonczona($storedEvent, $rachunek));
    }

    /**
     * @param  PrzelewWychodzacy  $event
     * @param  StoredEvent        $storedEvent
     * @param  string             $aggregateUuid
     */
    public function onPrzelewWychodzacy(PrzelewWychodzacy $event, StoredEvent $storedEvent, string $aggregateUuid): void
    {
        $rachunek = Rachunek::find($aggregateUuid);

        $rachunekPowiazany = Rachunek::numer($event->nrRachunkuPowiazanego);

        $rachunek->odejmijZSalda($event->kwota);

        event(new TransakcjaZakonczona($storedEvent, $rachunek, $rachunekPowiazany));
    }

    /**
     * @param  PrzelewPrzychodzacy  $event
     * @param  StoredEvent          $storedEvent
     * @param  string               $aggregateUuid
     */
    public function onPrzelewPrzychodzacy(PrzelewPrzychodzacy $event,
                                          StoredEvent $storedEvent,
                                          string $aggregateUuid): void
    {
        $rachunek = Rachunek::find($aggregateUuid);

        $rachunekPowiazany = Rachunek::numer($event->nrRachunkuPowiazanego);

        $rachunek->dodajDoSalda($event->kwota);

        event(new TransakcjaZakonczona($storedEvent, $rachunek, $rachunekPowiazany));
    }
}
