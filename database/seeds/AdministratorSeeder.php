<?php

use App\Administrator;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'email'    => 'adam.zuczek@gmail.com',
            'imie'     => 'Adam',
            'nazwisko' => 'Żuczek',
            'pin'      => '1234',
            'password' => Hash::make('tajne'),
            'typ'      => 'administrator',
        ])->admin()->save(factory(Administrator::class)->make(['stanowisko' => 'Prezes']));
    }
}
