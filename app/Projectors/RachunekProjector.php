<?php

namespace App\Projectors;

use App\Events\Przelew;
use App\Events\StworzenieRachunku;
use App\Events\TransakcjaZakonczona;
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
            'id'          => $aggregateUuid,
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
     * @param  string            $aggregateUuid
     */
    public function onWyplataPieniedzy(WyplataPieniedzy $event, StoredEvent $storedEvent, string $aggregateUuid): void
    {
        $rachunek = Rachunek::find($aggregateUuid);

        $rachunek->odejmijZSalda($event->kwota);

        event(new TransakcjaZakonczona($storedEvent, $rachunek));
    }

    /**
     * @param  Przelew  $event
     * @param  string   $aggregateUuid
     */
    public function onPrzelew(Przelew $event, StoredEvent $storedEvent, string $aggregateUuid): void
    {
        $rachunek = Rachunek::find($aggregateUuid);

        // TODO tylko przelewy wewnetrzne?
        $rachunekDocelowy = Rachunek::numer($event->nrRachunkuDocelowego);

        DB::beginTransaction();
        $rachunek->odejmijZSalda($event->kwota);
        $rachunekDocelowy->dodajDoSalda($event->kwota);
        DB::commit();

        event(new TransakcjaZakonczona($storedEvent, $rachunek, $rachunekDocelowy));
    }
}
