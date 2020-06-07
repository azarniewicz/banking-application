<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class UserSettingsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if($user->is_zablokowana){
            \Auth::logout();
            return redirect()
                ->back()->withErrors(['Twoje konto zostało zablokowane']);
        }
        if($user->is_reset_password){
            return redirect()
                ->to('/uzytkownik/resetpassword');
        }
        if($user->is_reset_pin){
            return redirect()
                ->to('/uzytkownik/resetpin');
        }
        return $next($request);
    }
}
