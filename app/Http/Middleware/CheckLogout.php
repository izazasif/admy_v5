<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\LoginToken;

class CheckLogout
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
        if (session()->has('user_mail')){
            $user_id = session()->get('user_id');
            // $logToken = session()->get('login_token');

            // $dbLogToken = LoginToken::where('user_id', $user_id)->where('token', $logToken)->first();
            // if($dbLogToken && $dbLogToken->status == 1){
            //     return $next($request);
            // }else{
            //     return redirect()->route('logout');
            // }
            return $next($request);
        }else{
            $url = $request->url();
            session()->put('url_to_serve', $url);
            return redirect()->route('signin');
        }
    }
}
