<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Frontend
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
        if (Auth::user() &&  Auth::user()->hasRole('employee')) {
            return $next($request);
        }else{

            return redirect()->route('login')->with('error','You have not user access');
        }
        // if(session()->has('language')){
        //     \App::setLocale('ar');
        // }
        // else{
        //     \App::setLocale('en');
        // }
        // return $next($request);
    }
}