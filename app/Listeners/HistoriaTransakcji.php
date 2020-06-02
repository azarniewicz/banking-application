<?php

namespace App\Listeners;

use App\Events\Przelew;
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
            'data'                    => $event->storedEvent->created_at,
            'typ'                     => $this->nazwaTransakcji($event->storedEvent->event_class),
            'id_rachunku_powiazanego' => $event->rachunekDocelowy->id ?? null,
            'tytul'                   => $event->storedEvent->event_properties['tytul'] ?? null,
        ]);

        if ($event->rachunekDocelowy) {
            Transakcja::create([
                'id_rachunku'             => $event->rachunekDocelowy->id,
                'saldo_po_transakcji'     => $event->rachunekDocelowy->saldo,
                'kwota'                   => $event->storedEvent->event_properties['kwota'],
                'data'                    => $event->storedEvent->created_at,
                'typ'                     => $this->nazwaTransakcji($event->storedEvent->event_class, true),
                'id_rachunku_powiazanego' => $event->rachunek->id ?? null,
                'tytul'                   => $event->storedEvent->event_properties['tytul'] ?? null,
            ]);
        }
    }

    /**
     * @param $value
     *
     * @return string
     */
    private function nazwaTransakcji(string $value, bool $docelowy = false): ?string
    {
        switch ($value) {
            case Przelew::class:
                return ($docelowy) ? 'Przelew przychodzący' : 'Przelew wychodzący';
            case WplataPieniedzy::class:
                return 'Wpłata';
            case WyplataPieniedzy::class:
                return 'Wypłata';
            default:
                return $value;
        }
    }
}
