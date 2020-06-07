<?php


namespace App;


use App\Jobs\WykonajTransakcje;

class TransakcjaEkspresowa extends Transakcja
{
    public function wykonaj()
    {
        WykonajTransakcje::dispatchNow($this);
    }
}
