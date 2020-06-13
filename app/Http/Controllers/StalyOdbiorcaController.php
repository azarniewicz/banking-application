<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StalyOdbiorca;

class StalyOdbiorcaController extends Controller
{
    private $stalyOdbiorca;

    public function __construct(StalyOdbiorca $stalyOdbiorca)
    {
        $this->stalyOdbiorca = $stalyOdbiorca;
    }
    public function store(Request $request){
        $idKlienta = auth()->user()->klient()->first()->id;
        $this->stalyOdbiorca->create(array_merge($request->all(),['id_klienta'=>$idKlienta]));
        return redirect()
            ->back()
                ->with('success','Stały odbiorca został dodany');
    }
    public function delete($id){
        $this->stalyOdbiorca->findOrFail($id)->delete();
        return redirect()
            ->back()
                ->with('success','Stały odbiorca został usunięty');
    }
    public function index(){
        $idKlienta = auth()->user()->klient()->first()->id;
        $data = $this->stalyOdbiorca->where('id_klienta',$idKlienta)->get();
        return view('uzytkownik/staliodbiorcy')->with('staliOdbiorcy',$data);
    }

}
