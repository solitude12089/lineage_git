<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Request;
class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }
        if(Auth::user()->status==9){
            dd("此帳號已被停權,請洽管理員");
        }
        $path = $request->path();
        $log = new \App\models\Usetrackers;
        $log->path = $path;
        $log->ip_address=Request::ip();
        $log->user_id = Auth::user()->email;
        $log->save();
        return $next($request);
    }
}
