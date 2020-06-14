<?php

namespace App;

use App\Jobs\WykonajTransakcje;
use Illuminate\Database\Eloquent\Model;

class TransakcjaPlanowana extends Transakcja
{
    /**
     * Zleć wykonanie transakcji o czasie definiowanym przez pole `data_wykonania`
     */
    public function wykonaj()
    {
        WykonajTransakcje::dispatch($this)->delay($this->data_wykonania);
    }
}
