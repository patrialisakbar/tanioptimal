<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah authenticated
        $user = auth()->user();
        
        if (!$user) {
            // User belum login, biarkan Filament handle redirect ke login
            return $next($request);
        }

        // Jika user sudah login tapi bukan admin, tolak akses
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized: Only admins can access this area.');
        }

        return $next($request);
    }
}
