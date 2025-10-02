<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();

        if (!$user) {
            // Belum login
            return redirect()->route('login');
        }

        // cek apakah role user termasuk yang diizinkan
        if (!in_array($user->role, $roles)) {
            // redirect ke dashboard sesuai role
            switch($user->role) {
                case 'pusat':
                    return redirect()->route('pusat.dashboard.index');
                case 'cabang':
                    return redirect()->route('cabang.dashboard.index');
                case 'owner':
                    return redirect()->route('owner.dashboard.index');
                default:
                    return redirect('/');
            }
        }
        return $next($request);
    }
}
