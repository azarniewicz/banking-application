<?php

namespace App\Http\Controllers;

use App\Kredyt;
use Illuminate\Http\Request;

class KredytController extends Controller
{
    private $kredyt;
    public function __construct(Kredyt $kredyt)
    {
        $this->kredyt = $kredyt;
    }
    public function setOdmowa($id){
        $this->kredyt->findOrFail($id)->setOdmowa();
        return redirect()
            ->back();
    }
    public function setZgoda($id){
        $this->kredyt->findOrFail($id)->setZgoda();
        return redirect()
            ->back();
    }
    public function setWniosek(Request $request){
        $idKlienta = auth()->user()->klient()->first()->id;
        $this->kredyt->setWniosek($request->all(),$idKlienta);
        return redirect()
            ->back()
                ->with('success','Dane zostały zapisane pomyślnie');
    }
}
