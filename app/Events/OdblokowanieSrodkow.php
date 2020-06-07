<?php

namespace App\Events;

use Spatie\EventSourcing\ShouldBeStored;

class OdblokowanieSrodkow implements ShouldBeStored
{
    /**
     * @var float
     */
    public $kwota;

    /**
     * @var string
     */
    public $wiadomosc;

    /**
     * Create a new event instance.
     *
     * @param  float   $kwota
     * @param  string  $wiadomosc
     */
    public function __construct(float $kwota, string $wiadomosc)
    {
        $this->kwota = $kwota;
        $this->wiadomosc = $wiadomosc;
    }
}
