<?php


namespace App\Http\Controllers;


use App\Klient;

class KlientController extends Controller
{
    public function index()
    {
        abort_if((!auth()->user()->isKlient()), 403);

        $klient = auth()->user()->klient;
        $rachunek = $klient->rachunek;
        $ostatnieTransakcje = $rachunek->transakcje()->orderBy('data', 'desc')->take(5)->get();

        return view('uzytkownik/start', compact(['rachunek', 'klient', 'ostatnieTransakcje']));
    }
}
