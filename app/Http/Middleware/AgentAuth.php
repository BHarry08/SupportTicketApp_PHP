<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AgentAuth
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
         if (Auth::guard("agents")->user()){
             return $next($request);
         }else{
             if (Auth::user()){
                 return redirect('/list');
             }
             return redirect('/agent/login');
         }
    }
}
