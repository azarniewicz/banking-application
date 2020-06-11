<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Kredyt;
use App\Http\Requests\UserRequest;
class AdministratorController extends Controller
{
    private $user;
    private $kredyt;
    public function __construct(User $user,Kredyt $kredyt)
    {
        $this->user = $user;
        $this->kredyt = $kredyt;
    }

    public function index(){
        return view("administrator/adminpanel")
            ->with('administrator', auth()->user())
            ->with('wnioski',$this->kredyt->getWnioski()->get());
    }
    public function storeUzytkownik(UserRequest $request)
    {
        $user = $this->user->store($request->all());
        return redirect()
            ->back()
                ->with('success','Klient został wprowadzony pomyślnie');
    }
    public function updateUzytkownik(UserRequest $request){
        $btnSubmit = $request->btnSubmit;
        $user = $this->user->findOrFail($request->id);
        switch($btnSubmit){
            case "ZMIEŃ DANE":
                $user->edit($request->all());
            break;
            case "ZABLOKUJ":
                $user->setLock();
            break;
            case "PONOWNA AKTYWACJA":
                $user->setUnlock();
            break;
            case "RESTART HASŁA":
                $user->setResetPassword();
            break;
            case "RESTART PINU":
                $user->setResetPin();
            break;
        }
        return redirect()
            ->back()
                ->with('success','Zmiany zostały zapisane pomyślnie');

    }

}
