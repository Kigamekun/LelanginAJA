<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkBlacklistApi
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
            if ($request->user()->blacklist) {
                return response()->json(['message'=>"You're Account has been blacklisted"], 410);
            } else {
                return $next($request);
            }
    }
}
