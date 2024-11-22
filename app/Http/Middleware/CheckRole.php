<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Pastikan pengguna sudah terautentikasi sebelum memeriksa peran
        if (!$request->user() || $request->user()->role !== $role) {
            return response()->json(['message' => 'Access Denied'], 403);
        }

        return $next($request);
    }
}
