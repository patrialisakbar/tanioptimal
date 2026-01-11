<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FilamentAdminAuthenticate
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
            // Jika tidak authenticated, biarkan default behavior (akan redirect ke login)
            return $next($request);
        }

        // Jika user authenticated tapi bukan admin, abort 403
        if ($user->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke admin panel. Hanya admin yang dapat mengakses.');
        }

        return $next($request);
    }
}
