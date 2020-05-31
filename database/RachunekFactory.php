<?php

use App\RachunekAggregateRoot;
use Faker\Provider\pl_PL\Payment;

class RachunekFactory
{
    public static function createRachunekUsingAggregate(string $uuid, float $kwota = 0, int $nrKlienta = 1)
    {
        $aggregate = RachunekAggregateRoot::retrieve($uuid);

        $aggregate->utworzRachunekKlienta($nrKlienta, Payment::bankAccountNumber());

        if ($kwota != 0) {
            $aggregate->wplac($kwota);
        }

        return $aggregate->persist();
    }
}
