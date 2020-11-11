<?php

namespace App\Http\Middleware;

use Closure;

class IsAuthenticateMiddleware
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
        if(!$request->session()->get('user_data')){
            return redirect('/login')->with('error', "You are not authenticated please login first");
        }
        return $next($request);
    }
}
