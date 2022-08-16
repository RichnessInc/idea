<?php

namespace App\Http\Middleware;

use App\Models\chatGroup as CG;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class enterToGroup
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
        $gid = $request->route('id');
        $check = CG::findOrFail($gid);
        if ($check->buyer_id == Auth::guard('clients')->user()->id ||
            $check->provieder_id == Auth::guard('clients')->user()->id ||
            $check->sender_id == Auth::guard('clients')->user()->id) {
            return $next($request);
        } else {
            return redirect('/');
        }
    }
}
