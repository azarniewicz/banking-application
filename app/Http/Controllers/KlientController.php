<?php


namespace App\Http\Controllers;


class KlientController extends Controller
{
    public function index()
    {
        $klient = auth()->user()->klient;
        $rachunek = $klient->rachunek;
        $ostatnieTransakcje = $rachunek->transakcje()->orderBy('data', 'desc')->take(5)->get();

        return view('uzytkownik/start', compact(['rachunek', 'klient', 'ostatnieTransakcje']));
    }
}
