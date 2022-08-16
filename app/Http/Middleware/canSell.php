<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class canSell
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('clients')->check()) {
            if (Auth::guard('clients')->user()->status != 0) {
                if (Auth::guard('clients')->user()->type == 1 || Auth::guard('clients')->user()->type == 2) {
                    return $next($request);
                } else {
                    return redirect('/');
                }
            } else {
                Auth::guard('clients')->logout();
                return redirect('/login');
            }
        } else {
            return redirect('/login');
        }
    }
}
