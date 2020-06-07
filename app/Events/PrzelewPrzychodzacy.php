<?php

namespace App\Events;



class PrzelewPrzychodzacy extends Przelew
{
    /**
     * Create a new event instance.
     *
     * @param  string  $nrRachunkuPowiazanego
     * @param  string  $tytul
     * @param  float   $kwota
     */
    public function __construct(string $nrRachunkuPowiazanego, string $tytul, float $kwota)
    {
        parent::__construct($nrRachunkuPowiazanego, $tytul, $kwota);
    }

}
