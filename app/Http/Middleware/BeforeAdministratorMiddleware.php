<?php

namespace App\Http\Middleware;

use Closure;

use App\Administrator;
class BeforeAdministratorMiddleware
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
        if(Administrator::checkAuth()){
            return redirect()->to('/adminpanel');
        }
        return $next($request);
    }
}
