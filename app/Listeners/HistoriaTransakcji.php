<?php

namespace App\Listeners;

use App\Events\Przelew;
use App\Events\PrzelewPrzychodzacy;
use App\Events\PrzelewWychodzacy;
use App\Events\TransakcjaZakonczona;
use App\Events\WplataPieniedzy;
use App\Events\WyplataPieniedzy;
use App\Transakcja;

class HistoriaTransakcji
{

    /**
     * Handle the event.
     *
     * @param  TransakcjaZakonczona  $event
     *
     * @return void
     */
    public function handle(TransakcjaZakonczona $event)
    {
        Transakcja::create([
            'id_rachunku'             => $event->rachunek->id,
            'saldo_po_transakcji'     => $event->rachunek->saldo,
            'kwota'                   => $event->storedEvent->event_properties['kwota'],
            'data_zlecenia'           => $event->storedEvent->created_at,
            'data_wykonania'          => now(),
            'typ'                     => $this->nazwaTransakcji($event->storedEvent->event_class),
            'nr_rachunku_powiazanego' => $event->rachunekDocelowy->nr_rachunku ?? null,
            'tytul'                   => $event->storedEvent->event_properties['tytul'] ?? null,
            'odbiorca'                => $event->storedEvent->event_properties['nazwaOdbiorcy'] ?? null,
        ]);
    }

    /**
     * @param $value
     *
     * @return string
     */
    private function nazwaTransakcji(string $value): ?string
    {
        switch ($value) {
            case PrzelewPrzychodzacy::class:
                return 'Przelew przychodzący';
            case PrzelewWychodzacy::class:
                return 'Przelew wychodzący';
            case WplataPieniedzy::class:
                return 'Wpłata';
            case WyplataPieniedzy::class:
                return 'Wypłata';
            default:
                return $value;
        }
    }
}
