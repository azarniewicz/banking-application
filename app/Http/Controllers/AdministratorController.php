<?php

namespace App\Http\Controllers;

use App\Administrator;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

class AdministratorController extends Controller
{
    private $administrator;

    public function __construct(Administrator $administrator)
    {
        $this->administrator = $administrator;
    }

    public function login(Request $request){

        if($this->administrator->login($request->all(),$request->filled('remember'))){

            return redirect()->action('AdministratorController@index');
        }
        return redirect()->back();
    }
    public function index(){

        return view("administrator/adminpanel")
            ->with('administrator',$this->administrator->getAdmin());
    }
    public function showLogin(){
        return view('auth/login');
    }

}
