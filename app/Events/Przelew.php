<?php

namespace App\Events;

class Przelew extends WykonanieTransakcji
{
    /**
     * @var string
     */
    public $nrRachunkuDocelowego;

    /**
     * @var string
     */
    public $tytul;

    /**
     * Create a new event instance.
     *
     * @param  string  $nrRachunkuDocelowego
     * @param  string  $tytul
     * @param  float   $kwota
     */
    public function __construct(string $nrRachunkuDocelowego, string $tytul, float $kwota)
    {
        parent::__construct($kwota);
        $this->nrRachunkuDocelowego = $nrRachunkuDocelowego;
        $this->tytul                = $tytul;
    }

}
