<?php

namespace App\Http\Controllers;

use App\Exceptions\NiewystarczajaceSrodki;
use App\Exceptions\NieznanyTypTransakcji;
use App\Http\Requests\TransakcjaRequest;
use App\RachunekAggregateRoot;
use App\Transakcja;
use Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransakcjaController extends Controller
{

    use RefreshDatabase;

    /**
     * @var RachunekAggregateRoot
     */
    private $rachunekAggregateRoot;


    public function __construct(RachunekAggregateRoot $rachunekAggregateRoot)
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) use ($rachunekAggregateRoot) {
            $this->rachunekAggregateRoot = $rachunekAggregateRoot::retrieve(auth()->user()->getRachunekKlienta()->id);
            return $next($request);
        });
    }

    public function index()
    {
        $transakcje = auth()->user()
                            ->getRachunekKlienta()
                            ->transakcje()
                            ->orderBy('data_wykonania', 'desc')
                            ->get();

        return view('uzytkownik/historia', compact('transakcje'));
    }

    public function create()
    {
        return view('uzytkownik/przelew');
    }

    public function createPlanowana()
    {
        return view('uzytkownik/planowanetransakcje');
    }

    public function store(TransakcjaRequest $request)
    {
        try {
            $this->rachunekAggregateRoot->zablokujSrodki($request->get('kwota'))->persist();

            $transakcja = Transakcja::makeFrom([
                'nr_rachunku'             => $this->rachunekAggregateRoot->nrRachunku,
                'nr_rachunku_powiazanego' => $request->get('numer_rachunku'),
                'kwota'                   => $request->get('kwota'),
                'tytul'                   => $request->get('tytul'),
                'odbiorca'                => $request->get('odbiorca'),
                'data_wykonania'          => $request->get('data_wykonania', null),
            ], $request->get('typ'));

            $transakcja->wykonaj();

        } catch (NiewystarczajaceSrodki $e) {
            return redirect()->back()->withErrors(['kwota' => $e->getMessage()]);
        } catch (NieznanyTypTransakcji $e) {
            $this->rachunekAggregateRoot->odblokujSrodki($request->get('kwota'), $e->getMessage())->persist();
            return redirect()->back()->withErrors(['typ' => $e->getMessage()]);
        } catch (\Exception $e) {
            $this->rachunekAggregateRoot->odblokujSrodki($request->get('kwota'), $e->getMessage())->persist();
            return redirect()->back()->withErrors(['Błąd podczas przetwarzania transakcji.']);
        }

        return redirect()->back()->with('success', 'Pomyślnie zlecono wykonanie transakcji.');
    }
}
