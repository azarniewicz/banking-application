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
use Illuminate\Support\Facades\Schema;
use Spatie\EventSourcing\Projectors\Projector;
use Spatie\EventSourcing\Projectors\ProjectsEvents;
use Spatie\EventSourcing\StoredEvent;

/**
 * Class RachunekProjector
 *
 * Ta klasa zbiera wszystkie zdefiniowane eventy i wysyła odpowiednie zapytania do bazy.
 * Type Hint eventu podpowiada który event ma "wpaść" w którą metodę.
 *
 */
class RachunekProjector implements Projector
{
    use ProjectsEvents;

    /**
     * Wywolywana przy starcie odtwarzania eventow
     */
    public function onStartingEventReplay()
    {
        Schema::disableForeignKeyConstraints();
        // Przed odtowrzeniem wszystkich eventów i zrekonstruowania tabel, usuwamy z nich obecne dane
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
