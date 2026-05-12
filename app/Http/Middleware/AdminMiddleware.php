<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!in_array(auth()->user()->role, ['admin', 'super_admin'])) {
        return redirect('/dashboard')->with('error', 'Access denied');
        }

        return $next($request);
    }
}