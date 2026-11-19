<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PemilikLapangan;

class SportifyAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ?string $role = null): Response
    {
        if (!session()->has('sportify_user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        }

        if ($role && session('sportify_user_role') !== $role) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
        }

        // Khusus pemilik lapangan: kunci akses jika akun belum disetujui admin
        if (session('sportify_user_role') === 'pemilik') {
            $pemilik = PemilikLapangan::find(session('sportify_user_id'));

            if (!$pemilik) {
                session()->flush();
                return redirect()->route('login')->with('error', 'Akun pemilik tidak ditemukan.');
            }

            if ($pemilik->status_verifikasi === 'rejected') {
                session()->flush();
                return redirect()->route('login')->with('error', 'Akun pemilik lapangan Anda telah ditolak oleh administrator.');
            }

            // Jika akun belum approved (misal: pending), hanya boleh membuka dashboard (tampilan menunggu) dan logout
            if ($pemilik->status_verifikasi !== 'approved') {
                if (!$request->routeIs('pemilik.dashboard') && !$request->routeIs('logout')) {
                    return redirect()->route('pemilik.dashboard')->with('error', 'Akun Anda sedang menunggu verifikasi administrator. Fitur pemilik belum dapat diakses.');
                }
            }
        }

        return $next($request);
    }
}


