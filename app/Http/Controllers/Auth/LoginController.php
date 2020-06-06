<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('wyloguj');
    }

    protected function authenticated(Request $request, $user)
    {
        if($user->is_zablokowana){
            \Auth::logout();
            return redirect()
                ->back()->withErrors(['Twoje konto zostało zablokowane']);
        }
        if($user->is_reset_password){
            return redirect()
                ->to('/uzytkownik/resetpassword');
        }
    }

    public function wyloguj(){
        \Auth::logout();
        return redirect()->to("/login");
    }
}
