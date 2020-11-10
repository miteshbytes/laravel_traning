<?php

namespace App\Http\Middleware;

use Closure;

class AdminAuthenticated
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
        if($request->session()->get('user_data')['role_id'] != 1){
            return redirect('/students')->with('message', "You are to not allowed access admin pannel!");
        }
        return $next($request);
    }
}
