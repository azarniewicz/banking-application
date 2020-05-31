<?php

namespace App\Events;

use Spatie\EventSourcing\ShouldBeStored;

class StworzenieRachunku implements ShouldBeStored
{

    /**
     * @var int
     */
    public $idKlienta;

    /**
     * @var string
     */
    public $numerRachunku;

    /**
     * Create a new event instance.
     *
     * @param  int     $idKlienta
     * @param  string  $numerRachunku
     */
    public function __construct(int $idKlienta, string $numerRachunku)
    {
        $this->idKlienta     = $idKlienta;
        $this->numerRachunku = $numerRachunku;
    }
}
