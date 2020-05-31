<?php

use App\RachunekAggregateRoot;
use Faker\Provider\pl_PL\Payment;

class RachunekFactory
{
    public static function createRachunekUsingAggregate(string $uuid, int $nrKlienta = 1, float $kwota = 0)
    {
        $aggregate = RachunekAggregateRoot::retrieve($uuid)
                                          ->utworzRachunekKlienta($nrKlienta, Payment::bankAccountNumber());

        if ($kwota !== 0) {
            $aggregate->wplac($kwota);
        }

        return $aggregate->persist();
    }
}
