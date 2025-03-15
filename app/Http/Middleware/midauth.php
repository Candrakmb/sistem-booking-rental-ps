<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MidAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Redirect berdasarkan role jika pengguna mencoba mengakses halaman yang salah
        if ($user->role === 'admin' && !$request->is('admin*')) {
            return redirect()->route('dashboard');
        }

        if ($user->role === 'user' && !$request->is('transaksi*')) {
            return redirect()->route('transaksi');
        }

        return $next($request);
    }
}
