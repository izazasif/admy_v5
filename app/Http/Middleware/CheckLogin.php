<?php

namespace App\Http\Middleware;
use Illuminate\Http\Response;
use Closure;

class CheckLogin
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
        if(session()->has('user_mail'))
        {
             //echo "<br> u r in login at present";
            //  return new Response(view('middle'));

            return redirect()->route('home');
           
        } else{
            return $next($request);
        }
    }
}
