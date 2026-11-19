<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $module): Response
    {
        $user = auth()->user();

        // 1. Jika Super Admin, izinkan akses penuh tanpa batasan modul
        if ($user && $user->role === 'Super Admin') {
            return $next($request);
        }

        // 2. Periksa apakah user memiliki modul yang diminta di dalam array modules miliknya
        if ($user && is_array($user->modules) && in_array($module, $user->modules)) {
            return $next($request);
        }

        // 3. Jika tidak memiliki akses, abort 403 (Unauthorized) atau redirect kembali dengan pesan error
        abort(403, 'Maaf, Anda tidak memiliki hak akses untuk masuk ke modul ini.');
    }
}
