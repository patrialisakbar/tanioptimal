<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FilamentAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect('/admin/login');
        }

        // Check if user has admin role
        if (auth()->user()->role !== 'admin') {
            auth()->logout();
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke admin panel. Hanya admin yang dapat login.');
        }

        return $next($request);
    }
}
