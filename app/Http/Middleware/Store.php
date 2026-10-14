<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Store
{
    /**
     * Handle an incoming request.
     *
     * Lets signed-in admins (user_type 1) and staff (user_type 2) into the store area.
     * There is no licence check any more: the system is not sold, so nobody is locked out.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ((Auth::check()) && (Auth::user()->user_type==2 || Auth::user()->user_type==1)) {
            return $next($request);
        }
        return redirect('/');
    }
}
