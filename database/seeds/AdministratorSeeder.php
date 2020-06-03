<?php

use App\Administrator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('administracja')->insert([
            'email'    => 'adam.zuczek@gmail.com',
            'imie'     => 'Adam',
            'nazwisko' => 'Żuczek',
            'password' => Hash::make('tajne'),
            'stanowisko'=>'Prezes',
            'pin'=>'1234'
        ]);

    }
}
