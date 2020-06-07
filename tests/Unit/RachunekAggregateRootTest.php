<?php


namespace Tests\Unit;


use App\Exceptions\BrakWystarczajacychSrodkow;
use App\Rachunek;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RachunekAggregateRootTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function tworzy_rachunek()
    {
        $uuid = $this->getNewUuid();
        \RachunekFactory::createRachunekUsingAggregate($uuid, 1000);

        $this->assertNotNull(Rachunek::find($uuid));
    }

    /** @test */
    public function blokowanie_srodkow()
    {
        $uuid = $this->getNewUuid();
        $agregat = \RachunekFactory::createRachunekUsingAggregate($uuid, 1000);

        $agregat->zablokujSrodki(500)->persist();

        tap(Rachunek::numer($agregat->nrRachunku), function($rachunek) {
            $this->assertEquals(500, $rachunek->dostepne_srodki);
        });

        $agregat->odblokujSrodki(500)->persist();

        tap(Rachunek::numer($agregat->nrRachunku), function($rachunek) {
            $this->assertEquals(1000, $rachunek->dostepne_srodki);
        });
    }

    /** @test */
    public function wplata_trafia_na_konto()
    {
        $uuid = $this->getNewUuid();
        $aggregate = \RachunekFactory::createRachunekUsingAggregate($uuid);

        $aggregate->wplac(1000)->persist();

        $this->assertEquals(1000, Rachunek::find($uuid)->saldo);
    }

    /** @test */
    public function wyplata_jest_sciagana_z_konta()
    {
        $uuid = $this->getNewUuid();
        $aggregate = \RachunekFactory::createRachunekUsingAggregate($uuid, 1000);

        $aggregate->wyplac(1000)->persist();

        $this->assertEquals(0, Rachunek::find($uuid)->saldo);
    }

    /** @test */
    public function nie_mozna_pobrac_wiecej_niz_jest_na_koncie()
    {
        $uuid = $this->getNewUuid();
        $aggregate = \RachunekFactory::createRachunekUsingAggregate($uuid, 1000);

        try {
            $aggregate->wyplac(2000)->persist();
        } catch (BrakWystarczajacychSrodkow $e) {
            $this->assertEquals(1000, Rachunek::find($uuid)->saldo);
            return;
        }

        $this->fail('Udalo sie wyplacic pieniadze ktorych nie bylo na koncie');
    }
}
