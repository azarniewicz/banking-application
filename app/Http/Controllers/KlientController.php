<?php


namespace App\Http\Controllers;


class KlientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        abort_if((!auth()->user()->isKlient()), 403);

        $klient = auth()->user()->klient;
        $rachunek = $klient->rachunek;
        $ostatnieTransakcje = $rachunek->transakcje()->orderBy('data_wykonania', 'desc')->take(5)->get();

        return view('uzytkownik/start', compact(['rachunek', 'klient', 'ostatnieTransakcje']));
    }

    public function show()
    {
        $klient = auth()->user()->klient;

        return view('uzytkownik/mojedane', compact('klient'));
    }
}
