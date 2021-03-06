<?php

namespace App\Http\Controllers;

use App\Http\Requests\StalyOdbiorcaRequest;
use App\StalyOdbiorca;

class StalyOdbiorcaController extends Controller
{
    private $stalyOdbiorca;

    public function __construct(StalyOdbiorca $stalyOdbiorca)
    {
        $this->stalyOdbiorca = $stalyOdbiorca;
    }
    public function store(StalyOdbiorcaRequest $request){
    // Funkcja dodająca stałego odbiorcę
        $idKlienta = auth()->user()->klient()->first()->id;
        $this->stalyOdbiorca->create(array_merge($request->all(),['id_klienta'=>$idKlienta]));
        return redirect()
            ->back()
                ->with('success','Stały odbiorca został dodany');
    }
     // Funkcja usuwająca stałego odbiorcę
    public function delete($id){
        $this->stalyOdbiorca->findOrFail($id)->delete();
        return redirect()
            ->back()
                ->with('success','Stały odbiorca został usunięty');
    }
      // Funkcja która zwraca widok, i stałych odbiorców przypisanych do klienta
    public function index(){
        $idKlienta = auth()->user()->klient()->first()->id;
        $data = $this->stalyOdbiorca->where('id_klienta',$idKlienta)->get();
        return view('uzytkownik/staliodbiorcy')->with('staliOdbiorcy',$data);
    }

}
