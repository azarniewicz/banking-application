<?php

namespace App\Http\Middleware;

use Closure;

use App\Administrator;


class AdministratorMiddleware
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
        $checkAuth = Administrator::checkAuth();
        if($checkAuth){
           return $next($request);
        }
        else{
            return redirect()->to('/adminpanel/login');
        }
    }
}
