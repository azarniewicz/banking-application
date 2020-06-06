<?php

use App\Klient;
use App\User;
use App\UuidGenerator;
use Faker\Provider\pl_PL\Person;
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

        $userA = factory(User::class)->create([
            'email'    => 'jan@kowalski.com',
            'imie'     => 'Jan',
            'nazwisko' => 'Kowalski',
            'pin'      => '1234',
            'password' => Hash::make('tajne'),
            'typ'      => 'klient',
        ])->klient()->save(factory(Klient::class)->make());

        $userB = factory(User::class)->create([
            'email'    => 'janina@kowalska.com',
            'imie'     => 'Janina',
            'nazwisko' => 'Kowalska',
            'pin'      => '1234',
            'password' => Hash::make('tajne'),
            'typ'      => 'klient'
        ])->klient()->save(factory(Klient::class)->make());

        $rachunekA = RachunekFactory::createRachunekUsingAggregate(UuidGenerator::generuj(), 0, $userA->id);

        $rachunekB = RachunekFactory::createRachunekUsingAggregate(UuidGenerator::generuj(), 0, $userB->id);

        $iterator = range(1, 10);
        $this->command->getOutput()->progressStart(count($iterator));

        foreach ($iterator as $i) {
            $this->command->getOutput()->progressAdvance();
            $rachunekA->wplac($this->faker->numberBetween(1000, 2000));
            $rachunekA->przelej($rachunekB->nrRachunku, $this->faker->word, $this->faker->numberBetween(1, 500));
            $rachunekA->wyplac($this->faker->numberBetween(1, 500));

            $rachunekB->wplac($this->faker->numberBetween(1000, 2000));
            $rachunekB->przelej($rachunekA->nrRachunku, $this->faker->word, $this->faker->numberBetween(1, 500));
            $rachunekB->wyplac($this->faker->numberBetween(1, 500));
        }

        $rachunekA->persist();
        $rachunekB->persist();

        $this->command->getOutput()->progressFinish();
    }
}
