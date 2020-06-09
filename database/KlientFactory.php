<?php


use App\Klient;
use App\User;

class KlientFactory
{
    public static function create(array $overrides = [], float $kwota = 0)
    {
        $user = factory(User::class)->create($overrides)->klient()->save(factory(Klient::class)->make());
        RachunekFactory::createRachunekUsingAggregate(\App\UuidGenerator::generuj(), $kwota, $user->id);
        $user->klient->rachunek->dodajKarte();
        return $user->klient;
    }
}
