<?php

namespace App\Events;

class Przelew extends WykonanieTransakcji
{
    /**
     * @var string
     */
    public $nrRachunkuPowiazanego;

    /**
     * @var string
     */
    public $tytul;

    /**
     * Create a new event instance.
     *
     * @param  string  $nrRachunkuPowiazanego
     * @param  string  $tytul
     * @param  float   $kwota
     */
    public function __construct(string $nrRachunkuPowiazanego, string $tytul, float $kwota)
    {
        parent::__construct($kwota);
        $this->nrRachunkuPowiazanego = $nrRachunkuPowiazanego;
        $this->tytul                 = $tytul;
    }

}
