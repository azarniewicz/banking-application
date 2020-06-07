<?php

namespace App;

use App\Jobs\WykonajTransakcje;
use Illuminate\Database\Eloquent\Model;

class TransakcjaPlanowana extends Transakcja
{
    public function wykonaj()
    {
        WykonajTransakcje::dispatch($this)->delay($this->data_wykonania);
    }
}
