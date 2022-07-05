<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuth
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
        if (Auth::guard("admins")->user()){
            return $next($request);
        }else{
            if (Auth::user()){
                return redirect('/admin/list-agents');
            }
            return redirect('/admin/login');
        }
    }
}
