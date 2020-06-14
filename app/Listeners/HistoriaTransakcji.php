<?php

namespace App\Listeners;

use App\Events\TransakcjaZakonczona;
use App\Transakcja;

class HistoriaTransakcji
{

    /**
     * Tworzy wpis do tabeli `transakcje` na podstawie eventu TransakcjaZakonczona
     *
     * @param  TransakcjaZakonczona  $event
     *
     * @return void
     */
    public function handle(TransakcjaZakonczona $event)
    {
        Transakcja::create([
            'nr_rachunku'             => $event->rachunek->nr_rachunku,
            'saldo_po_transakcji'     => $event->rachunek->saldo,
            'kwota'                   => $event->storedEvent->event_properties['kwota'],
            'data_zlecenia'           => $event->storedEvent->created_at,
            'data_wykonania'          => now(),
            'typ'                     => Transakcja::nazwaTransakcji($event->storedEvent->event_class),
            'nr_rachunku_powiazanego' => $event->rachunekDocelowy->nr_rachunku ?? null,
            'tytul'                   => $event->storedEvent->event_properties['tytul'] ?? null,
            'odbiorca'                => $event->storedEvent->event_properties['nazwaOdbiorcy'] ?? null,
        ]);
    }

}
