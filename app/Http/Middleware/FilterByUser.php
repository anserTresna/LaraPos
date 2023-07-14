<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FilterByUser
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
        $user = $request->user();

        // Filter data berdasarkan user yang sedang login
        $request->merge(['user_id' => $user->id]);
        
        return $next($request);
    }
}
