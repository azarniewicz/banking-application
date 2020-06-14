<?php


namespace App\Http\Controllers;


use App\Http\Requests\KlientRequest;
use App\User;
use Illuminate\Support\Carbon;
class KlientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        abort_if((!auth()->user()->isKlient()), 403);

        $klient             = auth()->user()->klient;
        $rachunek           = $klient->rachunek;

        $ostatnieTransakcje = $rachunek->transakcje()->orderBy('data_wykonania', 'desc')->take(5)->get();

        $carbon = Carbon::parse(auth()->user()->ostatnie_logowanie);
        $ostatnieLogowanie = $carbon->toDateTimeString();
        $diff = $carbon->diffAsCarbonInterval(Carbon::now());

        return view('uzytkownik/start', compact(['rachunek', 'klient', 'ostatnieTransakcje','ostatnieLogowanie','diff']));
    }

    public function show()
    {
        $klient = auth()->user()->klient;

        return view('uzytkownik/mojedane', compact('klient'));
    }


    public function update(KlientRequest $request)
    {
        auth()->user()->klient->fill(array_filter($request->validated()))->save();

        return redirect()->back()->with('success', 'Dane pomyślnie zaktualizowane.');
    }
}
