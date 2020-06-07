<?php


use App\Klient;
use App\User;

class KlientFactory
{
    public static function create(array $overrides = [], float $kwota = 0)
    {
        $klient = factory(User::class)->create($overrides)->klient()->save(factory(Klient::class)->make());
        RachunekFactory::createRachunekUsingAggregate(\App\UuidGenerator::generuj(), $kwota, $klient->id);
        return $klient;
    }
}
