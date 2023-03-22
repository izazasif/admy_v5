<?php

namespace App\Http\Middleware;

use Closure;

class CheckSMSManager
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
        if(session()->get('permission') == 'all' || session()->get('permission') == 'sms_creator' || session()->get('permission') == 'obd_sms_manager')
        {
            return $next($request);
        } else{
            return redirect()->route('home'); 
        }
    }
}
