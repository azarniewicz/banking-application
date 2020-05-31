<?php

namespace App\Projectors;

use App\Events\Przelew;
use App\Events\StworzenieRachunku;
use App\Events\WplataPieniedzy;
use App\Events\WyplataPieniedzy;
use App\Exceptions\RachunekNieIstnieje;
use App\Rachunek;
use Faker\Provider\pl_PL\Payment;
use Illuminate\Support\Facades\DB;
use Spatie\EventSourcing\Projectors\Projector;
use Spatie\EventSourcing\Projectors\ProjectsEvents;

class RachunekProjector implements Projector
{
    use ProjectsEvents;

    /**
     * @param  StworzenieRachunku  $event
     * @param  string              $aggregateUuid
     */
    public function onRachunekCreated(StworzenieRachunku $event, string $aggregateUuid): void
    {
        // TODO associate user using $event->idKlienta

        Rachunek::create([
            'uuid'        => $aggregateUuid,
            'nr_rachunku' => $event->numerRachunku
        ]);
    }

    /**
     * @param  WplataPieniedzy  $event
     * @param  string           $aggregateUuid
     */
    public function onWplataPieniedzy(WplataPieniedzy $event, string $aggregateUuid): void
    {
        $rachunek = Rachunek::uuid($aggregateUuid);

        $rachunek->dodajDoSalda($event->kwota);
    }

    /**
     * @param  WyplataPieniedzy  $event
     * @param  string            $aggregateUuid
     */
    public function onWyplataPieniedzy(WyplataPieniedzy $event, string $aggregateUuid): void
    {
        $rachunek = Rachunek::uuid($aggregateUuid);

        $rachunek->odejmijZSalda($event->kwota);
    }

    /**
     * @param  Przelew  $event
     * @param  string   $aggregateUuid
     */
    public function onPrzelew(Przelew $event, string $aggregateUuid): void
    {
        $rachunek = Rachunek::uuid($aggregateUuid);

        // TODO tylko przelewy wewnetrzne?
        $rachunekDocelowy = Rachunek::numer($event->nrRachunkuDocelowego);

        DB::beginTransaction();
        $rachunek->odejmijZSalda($event->kwota);
        $rachunekDocelowy->dodajDoSalda($event->kwota);
        DB::commit();
    }
}
