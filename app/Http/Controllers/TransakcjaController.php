<?php

namespace App\Http\Controllers;

use App\Exceptions\BrakWystarczajacychSrodkow;
use App\Exceptions\PrzelewNaTenSamRachunek;
use App\Http\Requests\TransakcjaRequest;
use App\Rachunek;
use App\RachunekAggregateRoot;
use Auth;

class TransakcjaController extends Controller
{
    /**
     * @var Rachunek
     */
    private $rachunek;
    /**
     * @var RachunekAggregateRoot
     */
    private $rachunekAggregateRoot;

    public function __construct(Rachunek $rachunek, RachunekAggregateRoot $rachunekAggregateRoot)
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) use ($rachunekAggregateRoot) {
            $this->rachunekAggregateRoot = $rachunekAggregateRoot::retrieve(auth()->user()->getRachunekKlienta()->id);
            return $next($request);
        });
        $this->rachunek = $rachunek;
    }

    public function index()
    {
        return view('uzytkownik/przelew');
    }

    public function store(TransakcjaRequest $request)
    {
        try {
            $this->rachunekAggregateRoot->przelej(
                $request->get('numer_rachunku'),
                $request->get('tytul'),
                $request->get('kwota')
            )->persist();
        } catch (BrakWystarczajacychSrodkow $e) {
            return redirect()->back()->withErrors(['kwota' => 'Brak wystarczających środków na koncie.']);
        } catch (PrzelewNaTenSamRachunek $e) {
            return redirect()->back()->withErrors(['numer_rachunku' => 'Nie możesz przelać pieniedzy na swoje konto.']);
        }

        return redirect()->back()->with('success', 'Przelew wykonany');
    }
}
