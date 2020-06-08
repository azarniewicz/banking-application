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
        $date = \Carbon\Carbon::yesterday();
        \Carbon\Carbon::setTestNow($date);

        $this->setUpFaker();

        $klientA = \KlientFactory::create([
            'email'    => 'jan@kowalski.com',
            'imie'     => 'Jan',
            'nazwisko' => 'Kowalski',
            'password' => Hash::make('tajne')
        ]);

        $klientB = \KlientFactory::create([
            'email'    => 'janina@kowalska.com',
            'imie'     => 'Janina',
            'nazwisko' => 'Kowalska',
            'password' => Hash::make('tajne')
        ]);

        $rachunekA = $klientA->rachunek->getAggregate();
        $rachunekB = $klientB->rachunek->getAggregate();

        $iterator = range(1, 10);
        $this->command->getOutput()->progressStart(count($iterator) * 2);

        foreach ($iterator as $i) {
            \Carbon\Carbon::setTestNow();
            \Carbon\Carbon::setTestNow($date->subDays($i));
            $rachunekA->wplac($this->faker->numberBetween(1000, 2000))->persist();
            $rachunekA->wyplac($this->faker->numberBetween(1, 500))->persist();
            $rachunekB->wplac($this->faker->numberBetween(1000, 2000))->persist();
            $rachunekB->wyplac($this->faker->numberBetween(1, 500))->persist();
            $this->command->getOutput()->progressAdvance();
        }

        \Carbon\Carbon::setTestNow();
        $date = \Carbon\Carbon::today();

        foreach ($iterator as $i) {
            \App\Transakcja::makeFrom([
                'nr_rachunku'             => $klientA->rachunek->nr_rachunku,
                'nr_rachunku_powiazanego' => $rachunekB->nrRachunku,
                'kwota'                   => $this->faker->numberBetween(1, 500),
                'tytul'                   => $this->faker->word,
                'odbiorca'                => $klientB->imie . ' ' . $klientB->nazwisko
            ], \App\Transakcja::ekspres)->wykonaj();

            \App\Transakcja::makeFrom([
                'nr_rachunku'             => $klientB->rachunek->nr_rachunku,
                'nr_rachunku_powiazanego' => $rachunekA->nrRachunku,
                'kwota'                   => $this->faker->numberBetween(1, 500),
                'tytul'                   => $this->faker->word,
                'odbiorca'                => $klientA->imie . ' ' . $klientA->nazwisko
            ], \App\Transakcja::ekspres)->wykonaj();

            \Carbon\Carbon::setTestNow($date->subDays(random_int(0, 5)));

            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
    }
}
