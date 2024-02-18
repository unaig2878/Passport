<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        // Si esta accediendo al login sin verificacion permitimos
        if ($request->is('*login') || $request->is('*aarte')) {
            return $next($request);
        }

        if (auth()->guard('sanctum')->check() === false) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autorizado',
                'data' => $request,
            ], 401);
        }
        return $next($request);
    }
}
