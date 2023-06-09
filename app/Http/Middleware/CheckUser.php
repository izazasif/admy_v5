<?php

namespace App\Http\Middleware;
use Illuminate\Http\Response;
use Closure;

class CheckUser
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
        if(session()->get('user_role') == 'user')
        {
            return $next($request);
        } else{
            return redirect()->route('home');
        }
    }
}
