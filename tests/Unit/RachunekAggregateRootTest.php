<?php


namespace Tests\Unit;


use App\Exceptions\BrakWystarczajacychSrodkow;
use App\Exceptions\PrzekroczonoLimitDzienny;
use App\Exceptions\PrzekroczonoLimitMiesieczny;
use App\Rachunek;
use Carbon\Carbon;
use Tests\RefreshDatabaseWithViews;
use Tests\TestCase;

class RachunekAggregateRootTest extends TestCase
{
    use RefreshDatabaseWithViews;

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

    /** @test */
    public function nie_mozna_przekroczyc_limitu_dziennego()
    {
        $klient = \KlientFactory::create([], 2000);

        $klient->update(['limit_dzienny' => 1000]);

        $this->actingAs($klient);

        try {
            $klient->rachunek->getAggregate()->wyplac(2000)->persist();
        } catch (PrzekroczonoLimitDzienny $e) {
            $this->assertEquals(2000, $klient->fresh()->rachunek->saldo);
            return;
        }

        $this->fail('Wyplacono srodki pomimo przekroczenia limitu dziennego.');
    }

    /** @test */
    public function nie_mozna_przekroczyc_limitu_miesiecznego()
    {
        $klient = \KlientFactory::create([], 2000);

        $klient->update(['ustawienie_budzetu' => 1000]);

        $this->actingAs($klient);

        Carbon::setTestNow(Carbon::yesterday());

        $klient->rachunek->getAggregate()->wyplac(500)->persist();

        Carbon::setTestNow();

        try {
            $klient->rachunek->getAggregate()->wyplac(500)->persist();
        } catch (PrzekroczonoLimitMiesieczny $e) {
            $this->assertEquals(1500, $klient->fresh()->rachunek->saldo);
            return;
        }

        $this->fail('Wyplacono srodki pomimo przekroczenia limitu dziennego.');
    }

    /** @test */
    public function wydatki_z_poprzedniego_miesiaca_nie_sa_brane_pod_uwage()
    {

        $klient = \KlientFactory::create([], 2000);

        $klient->update(['ustawienie_budzetu' => 1000]);

        $this->actingAs($klient);

        $agregat = $klient->rachunek->getAggregate();

        Carbon::setTestNow(Carbon::today()->subDays(32));

        $agregat->wyplac(900)->persist();

        Carbon::setTestNow();

        $agregat->fresh()->wyplac(200)->persist();

        $this->assertEquals(900, $klient->rachunek->fresh()->saldo);
    }
}
