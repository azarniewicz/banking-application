<?php


namespace Tests\Unit;


use App\Exceptions\BrakWystarczajacychSrodkow;
use App\Exceptions\PrzelewNaTenSamRachunek;
use App\Exceptions\RachunekNieIstnieje;
use App\Rachunek;
use Faker\Provider\pl_PL\Payment;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
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

        $this->assertNotNull(Rachunek::uuid($uuid));
    }

    /** @test */
    public function przelew()
    {
        $uuid1 = $this->getNewUuid();
        $rachunek = \RachunekFactory::createRachunekUsingAggregate($uuid1, 1000);

        $uuid2 = $this->getNewUuid();
        \RachunekFactory::createRachunekUsingAggregate($uuid2);
        $rachunek_docelowy = Rachunek::uuid($uuid2);

        $rachunek->przelej($rachunek_docelowy->nr_rachunku, 'testowy przelew', 1000)->persist();

        $this->assertEquals(0, $rachunek->saldo);
        $this->assertEquals(1000, $rachunek_docelowy->fresh()->saldo);
    }

    /** @test */
    public function nie_mozna_przelac_wiecej_niz_jest_na_koncie()
    {
        $uuid1 = $this->getNewUuid();
        $rachunek = \RachunekFactory::createRachunekUsingAggregate($uuid1, 1000);

        $uuid2 = $this->getNewUuid();
        \RachunekFactory::createRachunekUsingAggregate($uuid2);
        $rachunek_docelowy = Rachunek::uuid($uuid2);

        try {
            $rachunek->przelej($rachunek_docelowy->nr_rachunku, 'testowy przelew', 2000)->persist();
        } catch (BrakWystarczajacychSrodkow $e) {
            $this->assertEquals(1000, $rachunek->saldo);
            $this->assertEquals(0, $rachunek_docelowy->fresh()->saldo);
            return;
        }

        $this->fail('Udalo sie przelac pieniadze ktorych nie bylo na koncie');
    }

    /** @test */
    public function nie_mozna_zrobic_przelewu_na_ten_sam_rachunek()
    {
        $uuid1 = $this->getNewUuid();
        $rachunek = \RachunekFactory::createRachunekUsingAggregate($uuid1, 1000);

        try {
            $rachunek->przelej($rachunek->nrRachunku, 'testowy przelew', 1000)->persist();
        } catch (PrzelewNaTenSamRachunek $e) {
            $this->assertEquals(1000, $rachunek->saldo);
            return;
        }

        $this->fail('Udalo sie przelac pieniadze na ten sam rachunek');
    }

    /** @test */
    public function nie_mozna_przelac_pieniedzy_na_nieistniejacy_rachunek()
    {
        $uuid1 = $this->getNewUuid();
        $rachunek = \RachunekFactory::createRachunekUsingAggregate($uuid1, 1000);

        try {
            $rachunek->przelej('123-123-123', 'testowy przelew', 1000)->persist();
        } catch (RachunekNieIstnieje $e) {
            $this->assertEquals(1000, $rachunek->saldo);
            return;
        }

        $this->fail('Udalo sie przelac pieniadze na ten sam rachunek');
    }

    /** @test */
    public function wplata_trafia_na_konto()
    {
        $uuid = $this->getNewUuid();
        $aggregate = \RachunekFactory::createRachunekUsingAggregate($uuid);

        $aggregate->wplac(1000)->persist();

        $this->assertEquals(1000, Rachunek::uuid($uuid)->saldo);
    }

    /** @test */
    public function wyplata_jest_sciagana_z_konta()
    {
        $uuid = $this->getNewUuid();
        $aggregate = \RachunekFactory::createRachunekUsingAggregate($uuid, 1000);

        $aggregate->wyplac(1000)->persist();

        $this->assertEquals(0, Rachunek::uuid($uuid)->saldo);
    }

    /** @test */
    public function nie_mozna_pobrac_wiecej_niz_jest_na_koncie()
    {
        $uuid = $this->getNewUuid();
        $aggregate = \RachunekFactory::createRachunekUsingAggregate($uuid, 1000);

        try {
            $aggregate->wyplac(2000)->persist();
        } catch (BrakWystarczajacychSrodkow $e) {
            $this->assertEquals(1000, Rachunek::uuid($uuid)->saldo);
            return;
        }

        $this->fail('Udalo sie wyplacic pieniadze ktorych nie bylo na koncie');
    }
}
