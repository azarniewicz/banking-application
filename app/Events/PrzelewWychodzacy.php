<?php

namespace App\Events;

class PrzelewWychodzacy extends Przelew
{
    /**
     * @var string
     */
    public $nazwaOdbiorcy;

    /**
     * Create a new event instance.
     *
     * @param  string  $nrRachunkuPowiazanego
     * @param  string  $tytul
     * @param  float   $kwota
     * @param  string  $nazwaOdbiorcy
     */
    public function __construct(string $nrRachunkuPowiazanego, string $tytul, float $kwota, string $nazwaOdbiorcy)
    {
        parent::__construct($nrRachunkuPowiazanego, $tytul, $kwota);
        $this->nazwaOdbiorcy = $nazwaOdbiorcy;
    }

}
