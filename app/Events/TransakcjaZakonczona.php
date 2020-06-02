<?php

namespace App\Events;

use App\Rachunek;
use Spatie\EventSourcing\StoredEvent;

class TransakcjaZakonczona
{
    /**
     * @var StoredEvent
     */
    public $storedEvent;
    /**
     * @var Rachunek
     */
    public $rachunek;
    /**
     * @var Rachunek|null
     */
    public $rachunekDocelowy;


    /**
     * Create a new event instance.
     *
     * @param  StoredEvent  $storedEvent
     * @param  Rachunek     $rachunek
     * @param  Rachunek     $rachunekDocelowy
     */
    public function __construct(StoredEvent $storedEvent, Rachunek $rachunek, Rachunek $rachunekDocelowy = null)
    {
        $this->storedEvent           = $storedEvent;
        $this->rachunek              = $rachunek;
        $this->rachunekDocelowy      = $rachunekDocelowy;
    }

}
