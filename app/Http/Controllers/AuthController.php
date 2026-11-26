<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\PemilikLapangan;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('sportify_user_id')) {
            return redirect()->route('home');
        }
        return view('sportify.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = null;
        $role = null;

        // 1. Cek akun Administrator
        $admin = Admin::where('email', $email)->first();
        if ($admin && Hash::check($password, $admin->password)) {
            $user = $admin;
            $role = 'admin';
        }

        // 2. Cek akun Pemilik Lapangan
        if (!$user) {
            $pemilik = PemilikLapangan::where('email', $email)->first();
            if ($pemilik && Hash::check($password, $pemilik->password)) {
                $user = $pemilik;
                $role = 'pemilik';
            }
        }

        // 3. Cek akun Customer (Pelanggan)
        if (!$user) {
            $customer = Customer::where('email', $email)->first();
            if ($customer && Hash::check($password, $customer->password)) {
                $user = $customer;
                $role = 'customer';
            }
        }

        // Jika tidak ditemukan atau password tidak cocok di tabel manapun
        if (!$user) {
            return back()->withInput()->with('error', 'Email atau password yang Anda masukkan salah!');
        }

        if ($role === 'pemilik' && $user->status_verifikasi === 'rejected') {
            return back()->with('error', 'Akun pemilik lapangan Anda ditolak oleh administrator.');
        }

        session([
            'sportify_user_id' => $user->getKey(),
            'sportify_user_role' => $role,
            'sportify_user_name' => $user->nama ?? $user->nama_pemilik ?? $user->nama_admin,
            'sportify_user_email' => $user->email,
        ]);

        $redirectRoute = match ($role) {
            'admin' => route('admin.dashboard'),
            'pemilik' => route('pemilik.dashboard'),
            'customer' => route('home'),
        };

        return redirect($redirectRoute)->with('success', 'Selamat datang kembali, ' . session('sportify_user_name') . '!');
    }

    public function showRegister()
    {
        return view('sportify.auth.register');
    }

    public function register(Request $request)
    {
        $role = $request->input('role', 'customer');

        if ($role === 'pemilik') {
            $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|unique:pemilik_lapangan,email',
                'password' => 'required|min:6|confirmed',
                'no_wa' => 'required|string|max:15',
            ]);

            $pemilik = PemilikLapangan::create([
                'nama_pemilik' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_wa' => $request->no_wa,
                'status_verifikasi' => 'pending', // Menunggu persetujuan dari admin
            ]);


            return redirect()->route('login')->with('info', 'Pendaftaran pemilik lapangan berhasil! Akun Anda saat ini berstatus Menunggu Verifikasi Admin. Anda dapat login kembali setelah akun anda diverifikasi oleh AdminSportify.');
        } else {
            $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|unique:customer,email',
                'password' => 'required|min:6|confirmed',
                'no_wa' => 'required|string|max:15',
            ]);

            $customer = Customer::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_wa' => $request->no_wa,
            ]);

            return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silahkan login kembali menggunakan email dan password Anda.');
        }
    }

    public function logout()
    {
        session()->forget([
            'sportify_user_id',
            'sportify_user_role',
            'sportify_user_name',
            'sportify_user_email',
        ]);

        return redirect()->route('home')->with('success', 'Anda telah berhasil logout.');
    }
}
