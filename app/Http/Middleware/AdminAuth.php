<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah admin sudah login
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login')
                ->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman admin');
        }

        // Cek timeout session (optional: 2 jam)
        $loginTime = session('admin_login_time');
        if ($loginTime) {
            $timeout = 2 * 60 * 60; // 2 jam dalam detik
            if (now()->diffInSeconds($loginTime) > $timeout) {
                // Session timeout
                session()->forget([
                    'admin_logged_in',
                    'admin_username',
                    'admin_name',
                    'admin_email',
                    'admin_login_time'
                ]);
                
                return redirect()->route('admin.login')
                    ->with('error', 'Session Anda telah berakhir. Silakan login kembali.');
            }
            
            // Perpanjang session time setiap request (sliding session)
            session(['admin_login_time' => now()]);
        }

        return $next($request);
    }
}
