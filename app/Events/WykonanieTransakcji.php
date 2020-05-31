<?php


namespace App\Events;

use Spatie\EventSourcing\ShouldBeStored;

abstract class WykonanieTransakcji implements ShouldBeStored
{
    /**
     * @var float
     */
    public $kwota;

    /**
     * Create a new event instance.
     *
     * @param  float  $kwota
     */
    public function __construct(float $kwota)
    {
        $this->kwota = $kwota;
    }
}
