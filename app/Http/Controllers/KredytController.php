<?php

namespace App\Http\Controllers;

use App\Kredyt;
use App\User;
use App\RachunekAggregateRoot;
use App\Rata;
use App\vBiezaceKredyty;
use Illuminate\Http\Request;

class KredytController extends Controller
{
    private $kredyt;
    private $rata;
    private $rachunekAggregateRoot;
    private $user;
    private $vBiezaceKredyty;
    public function __construct(vBiezaceKredyty $vBiezaceKredyty,User $user,Kredyt $kredyt,Rata $rata,RachunekAggregateRoot $rachunekAggregateRoot)
    {
        $this->vBiezaceKredyty = $vBiezaceKredyty;
        $this->user = $user;
        $this->kredyt = $kredyt;
        $this->rata = $rata;
        $this->rachunekAggregateRoot = $rachunekAggregateRoot;
    }
    public function odrzucWniosek($id){
        $this->kredyt->findOrFail($id)
            ->setOdmowa();
        return redirect()
            ->back()
                ->with('success','Kredyt został odrzucony');
    }
    private function validationSetWniosek($idKlienta){
        if($this->kredyt->where('id_klienta',$idKlienta)->whereNull('zgoda_odmowa')->count() > 0){
            return [
                'error'=>true,
                'message'=>'Nie można złożyć wniosku, kiedy poprzedni wniosek nie został rozpatrzony'
            ];
        }
        if($this->vBiezaceKredyty->where('status_kredytu','W TOKU')->where('id_klienta',$idKlienta)->count() > 0){
            return [
                'error'=>true,
                'message'=>'Nie można wziąć następnego kredytu - nie został spłacony poprzedni kredyt'
            ];
        }
        return [
            'error'=>false
        ];
    }
    public function index(){
        return view('uzytkownik/kredyty')
            ->with('aktualneOprocentowanie',$this->kredyt::AKTUALNE_OPROCENTOWANIE)
            ->with('historiaSkladanychWnioskow',$this->kredyt->getHistoriaWnioskowOKredyt(auth()->user()->klient()->first()->id)->get());
    }
    public function zaakceptujWniosek($id){
        $kredyt = $this->kredyt->findOrFail($id)->setZgoda();
        $rachunekAggregateRoot = $this->rachunekAggregateRoot::retrieve($this->user->findOrFail($kredyt->id_klienta)->getRachunekKlienta()->id);
        $kredyt->przelejGotowke($rachunekAggregateRoot);
        $this->rata->store($kredyt->kwota_kredytu,$kredyt->ilosc_rat,$kredyt->id_kredytu);
        return redirect()
                ->back()
                    ->with('success','Kredyt został zaakceptowany');
    }
    public function setWniosek(Request $request){
        $idKlienta = auth()->user()->klient()->first()->id;
        $v = $this->validationSetWniosek($idKlienta);
        if(!$v['error']){
            $this->kredyt->setWniosek($request->all(),$idKlienta);

            return redirect()
                ->back()
                    ->with('success','Dane zostały zapisane pomyślnie');
        }
        return redirect()
                ->back()
                    ->withErrors([$v['message']]);
    }
}
