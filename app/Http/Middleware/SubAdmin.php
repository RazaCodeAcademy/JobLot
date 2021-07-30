<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubAdmin
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
        if (Auth::user() != null) {

            $role_id = DB::table('model_has_roles')
                ->select('role_id')
                ->where('model_id', Auth::user()->id)
                ->first();

            $role = $role_id->role_id;

            if($role == 4){
                $response = $next($request);
                return $response->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
                    ->header('Pragma','no-cache')
                    ->header('Expires','Fri, 01 Jan 1990 00:00:00 GMT');
            }

        }
        return redirect()->back();
    }
}
