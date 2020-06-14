<?php


namespace Tests\Unit;

use App\Rachunek;
use App\Transakcja;
use Tests\RefreshDatabaseWithViews;
use Tests\TestCase;

class TransakcjaTest extends TestCase
{
    use RefreshDatabaseWithViews;

    /** @test */
    public function wplaty_sa_wyswietlane()
    {
        $uuidA           = $this->getNewUuid();
        $agegatRachunkuA = \RachunekFactory::createRachunekUsingAggregate($uuidA);
        $rachunekA       = Rachunek::find($uuidA);

        $uuidB           = $this->getNewUuid();
        $agegatRachunkuB = \RachunekFactory::createRachunekUsingAggregate($uuidB);
        $rachunekB       = Rachunek::find($uuidB);

        $agegatRachunkuA->wplac(1000)->persist();
        $this->assertEquals(1, $rachunekA->transakcje()->count());

        sleep(1);

        $agegatRachunkuA->wplac(500)->persist();

        $this->assertEquals(1500, $rachunekA->transakcje()->latest('data_wykonania')->first()->saldo_po_transakcji);

        $transakcja = Transakcja::makeFrom([
            'nr_rachunku'             => $rachunekA->nr_rachunku,
            'nr_rachunku_powiazanego' => $rachunekB->nr_rachunku,
            'kwota'                   => 1000,
            'tytul'                   => 'test',
            'odbiorca'                => 'kowalski'
        ], Transakcja::ekspres);

        $transakcja->wykonaj();

        $this->assertEquals(1000, $rachunekB->transakcje()->latest('data_wykonania')->first()->saldo_po_transakcji);
    }

    /** @test */
    public function wplaty_sa_wyswietlane_w_tabeli_transakcji()
    {
        $uuid           = $this->getNewUuid();
        $agegatRachunku = \RachunekFactory::createRachunekUsingAggregate($uuid);
        $rachunek       = Rachunek::find($uuid);

        $agegatRachunku->wplac(1000)->persist();

        $this->assertEquals(1, $rachunek->transakcje()->count());

        tap($rachunek->transakcje()->first(), function ($transakcja) use ($rachunek) {
            $this->assertEquals($rachunek->nr_rachunku, $transakcja->nr_rachunku);
            $this->assertEquals('Wpłata', $transakcja->typ);
            $this->assertNull($transakcja->tytul);
            $this->assertNull($transakcja->nr_rachunku_powiazanego);
            $this->assertEquals(1000, $transakcja->kwota);
            $this->assertEquals(1000, $transakcja->saldo_po_transakcji);
        });
    }

    /** @test */
    public function wyplaty_sa_wyswietlane_w_widoku_transakcji()
    {
        $uuid           = $this->getNewUuid();
        $agegatRachunku = \RachunekFactory::createRachunekUsingAggregate($uuid, 1000);
        $rachunek       = Rachunek::find($uuid);

        sleep(1);

        $agegatRachunku->wyplac(1000)->persist();

        tap($rachunek->transakcje()->latest('data_wykonania')->first(), function ($transakcja) use ($rachunek) {
            $this->assertEquals($rachunek->nr_rachunku, $transakcja->nr_rachunku);
            $this->assertEquals('Wypłata', $transakcja->typ);
            $this->assertNull($transakcja->tytul);
            $this->assertNull($transakcja->nr_rachunku_powiazanego);
            $this->assertEquals(1000, $transakcja->kwota);
            $this->assertEquals(0, $transakcja->saldo_po_transakcji);
        });
    }

    /** @test */
    public function przelewy_sa_wyswietlane_w_tabeli_transakcji()
    {
        $uuidA = $this->getNewUuid();
        \RachunekFactory::createRachunekUsingAggregate($uuidA, 1000);
        $rachunekA = Rachunek::find($uuidA);

        $uuidB = $this->getNewUuid();
        \RachunekFactory::createRachunekUsingAggregate($uuidB);
        $rachunekB = Rachunek::find($uuidB);

        sleep(1);

        $transakcja = Transakcja::makeFrom([
            'nr_rachunku'             => $rachunekA->nr_rachunku,
            'nr_rachunku_powiazanego' => $rachunekB->nr_rachunku,
            'kwota'                   => 1000,
            'tytul'                   => 'test',
            'odbiorca'                => 'kowalski'
        ], Transakcja::ekspres);

        $transakcja->wykonaj();

        tap($rachunekA->transakcje()->latest('data_wykonania')->first(), function ($transakcja) use ($rachunekA, $rachunekB) {
            $this->assertEquals($rachunekA->nr_rachunku, $transakcja->nr_rachunku);
            $this->assertEquals('Przelew wychodzący', $transakcja->typ);
            $this->assertEquals('test', $transakcja->tytul);
            $this->assertEquals($rachunekB->nr_rachunku, $transakcja->nr_rachunku_powiazanego);
            $this->assertEquals(1000, $transakcja->kwota);
            $this->assertEquals(0, $transakcja->saldo_po_transakcji);
        });

        tap($rachunekB->transakcje()->latest('data_wykonania')->first(), function ($transakcja) use ($rachunekA, $rachunekB) {
            $this->assertEquals($rachunekB->nr_rachunku, $transakcja->nr_rachunku);
            $this->assertEquals('Przelew przychodzący', $transakcja->typ);
            $this->assertEquals('test', $transakcja->tytul);
            $this->assertEquals($rachunekA->nr_rachunku, $transakcja->nr_rachunku_powiazanego);
            $this->assertEquals(1000, $transakcja->kwota);
            $this->assertEquals(1000, $transakcja->saldo_po_transakcji);
        });
    }
}
