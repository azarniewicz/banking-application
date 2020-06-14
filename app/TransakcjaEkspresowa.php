<?php


namespace App;


use App\Jobs\WykonajTransakcje;

class TransakcjaEkspresowa extends Transakcja
{

    /**
     * Wykonaj natychmiast transakcję ( w trybie synchronicznym, z pominięciem kolejki )
     */
    public function wykonaj()
    {
        WykonajTransakcje::dispatchNow($this);
    }
}
