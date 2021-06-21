<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->path() === 'auth/login') {
            return $next($request);
        }
        if (!Auth::guard('admin')->check()) {
            return response()->json([
                'msg' => 'You are not authorized to access this resource.',
                'url' => $request->path()
            ], 403);
        }
        return $next($request);
    }
}
