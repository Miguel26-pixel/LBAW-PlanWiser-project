<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Unban
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
        if ($request->user() == null || $request->user()->is_banned) {
            return redirect('/home')->withErrors('User is banned');
        }
        return $next($request);
    }
}
