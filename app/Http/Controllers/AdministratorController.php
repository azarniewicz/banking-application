<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
class AdministratorController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(){
        return view("administrator/adminpanel")
            ->with('administrator', auth()->user());
    }
    public function editUser(Request $request){
        $btnSubmit = $request->btnSubmit;
        $user = $this->user->findOrFail($request->id);
        switch($btnSubmit){
            case "ZMIEŃ DANE":
                $user->edit($request->only(['imie','nazwisko','email']));
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
            ->back();

    }

}
