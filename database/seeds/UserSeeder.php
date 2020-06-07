<?php

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithFaker;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->setUpFaker();

        $klientA = \KlientFactory::create([
            'email' => 'jan@kowalski.com',
            'password' => Hash::make('tajne')
        ]);

        $klientB = \KlientFactory::create([
            'email' => 'janina@kowalski.com',
            'password' => Hash::make('tajne')
        ]);

        $rachunekA = $klientA->rachunek->getAggregate();
        $rachunekB = $klientB->rachunek->getAggregate();

        $iterator = range(1, 10);
        $this->command->getOutput()->progressStart(count($iterator));

        foreach ($iterator as $i) {
            $this->command->getOutput()->progressAdvance();
            $rachunekA->wplac($this->faker->numberBetween(1000, 2000))->persist();

            \App\Transakcja::makeFrom([
                'id_rachunku'             => $klientA->rachunek->id,
                'nr_rachunku_powiazanego' => $rachunekB->nrRachunku,
                'kwota'                   => $this->faker->numberBetween(1, 500),
                'tytul'                   => $this->faker->word,
                'odbiorca'                => $klientB->imie . ' ' . $klientB->nazwisko
            ], \App\Transakcja::standard)->wykonaj();

            $rachunekA->wyplac($this->faker->numberBetween(1, 500))->persist();

            $rachunekB->wplac($this->faker->numberBetween(1000, 2000))->persist();
            \App\Transakcja::makeFrom([
                'id_rachunku'             => $klientB->rachunek->id,
                'nr_rachunku_powiazanego' => $rachunekA->nrRachunku,
                'kwota'                   => $this->faker->numberBetween(1, 500),
                'tytul'                   => $this->faker->word,
                'odbiorca'                => $klientA->imie . ' ' . $klientA->nazwisko
            ], \App\Transakcja::standard)->wykonaj();
            $rachunekB->wyplac($this->faker->numberBetween(1, 500))->persist();

        }

        $this->command->getOutput()->newLine(2);
        $this->command->info('Executing transactions...');
        exec('php artisan queue:work --stop-when-empty');
        $this->command->info('Transactions executed.');

        $this->command->getOutput()->progressFinish();
    }
}
