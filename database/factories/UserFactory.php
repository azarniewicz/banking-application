<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Administrator;
use App\Klient;
use App\User;
use Faker\Generator as Faker;
use Faker\Provider\pl_PL\Person;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'imie'              => $faker->firstName,
        'nazwisko'          => $faker->lastName,
        'pin'               => $faker->numberBetween(1000, 9999),
        'typ'               => 'klient',
        'email'             => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
    ];
});

$factory->define(Klient::class, function (Faker $faker) {
    return [
        'pesel'              => Person::pesel(),
        'miasto'             => $this->faker->city,
        'ulica_nr'           => $this->faker->streetAddress,
        'kod_pocztowy'       => $this->faker->postcode,
        'nr_telefonu'        => $this->faker->e164PhoneNumber,
        'nr_dowodu'          => Person::personalIdentityNumber(),
        'limit_dzienny'      => 0,
        'ustawienie_budzetu' => 0,
    ];
});

$factory->define(Administrator::class, function (Faker $faker) {
    return [
        'stanowisko' => 'Prezes',
    ];
});
