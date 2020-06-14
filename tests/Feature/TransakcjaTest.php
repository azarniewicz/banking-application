<?php


namespace Tests\Feature;


use App\Http\Middleware\VerifyCsrfToken;
use App\Transakcja;
use Illuminate\Support\Facades\Hash;
use Tests\RefreshDatabaseWithViews;
use Tests\TestCase;

class TransakcjaTest extends TestCase
{
    use RefreshDatabaseWithViews;

    /** @test */
    public function przelew()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $klient1 = \KlientFactory::create([
            'email'    => 'jan@kowalski.com',
            'password' => Hash::make('tajne')
        ], 1000);

        $klient2 = \KlientFactory::create([
            'email'    => 'janina@kowalski.com',
            'password' => Hash::make('tajne')
        ]);

        $response = $this->actingAs($klient1)->from(url('przelew'))->post('przelew', [
            'numer_rachunku' => $klient2->rachunek->nr_rachunku,
            'kwota'          => 500,
            'tytul'          => 'test',
            'odbiorca'       => 'Kowalski',
            'typ'            => Transakcja::ekspres
        ]);

        $response->assertRedirect(url('przelew'));
        $response->assertSessionHas('success');

        $this->assertEquals(500, $klient2->rachunek->dostepne_srodki);
        $this->assertEquals(500, $klient1->rachunek->dostepne_srodki);
    }

    /** @test */
    public function nie_mozna_przelac_wiecej_niz_jest_na_koncie()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $klient1 = \KlientFactory::create([
            'email'    => 'jan@kowalski.com',
            'password' => Hash::make('tajne')
        ], 1000);

        $klient2 = \KlientFactory::create([
            'email'    => 'janina@kowalski.com',
            'password' => Hash::make('tajne')
        ]);

        $response = $this->actingAs($klient1)->from(url('przelew'))->post('przelew', [
            'numer_rachunku' => $klient2->rachunek->nr_rachunku,
            'kwota'          => 2000,
            'tytul'          => 'test',
            'odbiorca'       => 'Kowalski',
            'typ'            => Transakcja::ekspres
        ]);

        $response->assertRedirect(url('przelew'));
        $response->assertSessionHasErrors('kwota');

        $this->assertEquals(1000, $klient1->rachunek->dostepne_srodki);
        $this->assertEquals(0, $klient2->rachunek->dostepne_srodki);
    }

    /** @test */
    public function nie_mozna_zrobic_przelewu_na_ten_sam_rachunek()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $klient1 = \KlientFactory::create([
            'email'    => 'jan@kowalski.com',
            'password' => Hash::make('tajne')
        ], 1000);

        $response = $this->actingAs($klient1)->from(url('przelew'))->post('przelew', [
            'numer_rachunku' => $klient1->rachunek->nr_rachunku,
            'kwota'          => 1000,
            'tytul'          => 'test',
            'odbiorca'       => 'Kowalski',
            'typ'            => Transakcja::ekspres
        ]);

        $response->assertRedirect(url('przelew'));
        $response->assertSessionHasErrors('numer_rachunku');
        $this->assertEquals(1000, $klient1->rachunek->dostepne_srodki);
    }

    /** @test */
    public function nie_mozna_przelac_pieniedzy_na_nieistniejacy_rachunek()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $klient1 = \KlientFactory::create([
            'email'    => 'jan@kowalski.com',
            'password' => Hash::make('tajne')
        ], 1000);

        $response = $this->actingAs($klient1)->from(url('przelew'))->post('przelew', [
            'numer_rachunku' => 'PL11111111111111111111111111',
            'kwota'          => 1000,
            'tytul'          => 'test',
            'odbiorca'       => 'Kowalski',
            'typ'            => Transakcja::ekspres
        ]);

        $response->assertRedirect(url('przelew'));
        $response->assertSessionHasErrors('numer_rachunku');
        $this->assertEquals(1000, $klient1->rachunek->dostepne_srodki);
    }

}
