<?php

use App\RachunekAggregateRoot;
use Faker\Provider\pl_PL\Payment;

class RachunekFactory
{
    // TODO change idKlienta
    public static function createRachunekFromAggregate(string $uuid, float $kwota = 0)
    {
        return RachunekAggregateRoot::retrieve($uuid)
                                  ->utworzRachunekKlienta(1, Payment::bankAccountNumber())
                                  ->wplac($kwota)
                                  ->persist();
    }
}
