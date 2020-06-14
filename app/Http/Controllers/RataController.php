<?php

namespace App\Http\Controllers;

use App\Exceptions\BrakWystarczajacychSrodkow;
use App\RachunekAggregateRoot;
use Illuminate\Http\Request;

use App\Rata;
class RataController extends Controller
{
    private $rata;
    private $rachunekAggregateRoot;

    public function __construct(Rata $rata,RachunekAggregateRoot $rachunekAggregateRoot)
    {
        $this->rata = $rata;
        $this->rachunekAggregateRoot = $rachunekAggregateRoot;
    }
    public function zaplac($id){
       try{
            $rachunekAggregateRoot = $this->rachunekAggregateRoot::retrieve(auth()->user()->getRachunekKlienta()->id);
            $this->rata->findOrFail($id)->zaplac($rachunekAggregateRoot);
            return redirect()
                ->back()
                    ->with('success','Rata została opłacona pomyślnie');
       } catch(BrakWystarczajacychSrodkow $e){
            return redirect()->back()->withErrors(['kwota' => $e->getMessage()]);
       } catch(\Exception $e){
           return redirect()->back()->withErrors('Nie udało się wykonać transakcji.');
       }
    }
    public function index(){
        $klientId = auth()->user()->klient()->first()->id;
        return view('uzytkownik.raty')
            ->with('pozostaloRat',$this->rata->getPozostaloRat($klientId))
            ->with('pozostalaKwota',$this->rata->getPozostalaKwota($klientId))
            ->with('aktualnaRata',$this->rata->getAktualnaRata($klientId))
            ->with('poprzednieRaty',$this->rata->getPoprzednieRatyKlienta($klientId));
    }
}
