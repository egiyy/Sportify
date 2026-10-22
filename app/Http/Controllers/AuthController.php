<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\PemilikLapangan;
use App\Models\Point;

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
            'role' => 'required|in:customer,pemilik,admin',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $role = $request->input('role');
        $email = $request->input('email');
        $password = $request->input('password');

        $user = match ($role) {
            'admin' => Admin::where('email', $email)->first(),
            'pemilik' => PemilikLapangan::where('email', $email)->first(),
            'customer' => Customer::where('email', $email)->first(),
        };

        if (!$user || !Hash::check($password, $user->password)) {
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

    public function demoLogin(string $role)
    {
        $user = match ($role) {
            'admin' => Admin::first(),
            'pemilik' => PemilikLapangan::first(),
            'customer' => Customer::first(),
            default => null,
        };

        if (!$user) {
            return redirect()->route('login')->with('error', 'Data demo belum tersedia.');
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
            default => route('home'),
        };

        return redirect($redirectRoute)->with('success', 'Login otomatis sebagai ' . ucfirst($role) . ' (' . session('sportify_user_name') . ') berhasil!');
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
                'status_verifikasi' => 'approved',
            ]);

            session([
                'sportify_user_id' => $pemilik->id_pemilik,
                'sportify_user_role' => 'pemilik',
                'sportify_user_name' => $pemilik->nama_pemilik,
                'sportify_user_email' => $pemilik->email,
            ]);

            return redirect()->route('pemilik.dashboard')->with('success', 'Pendaftaran pemilik lapangan berhasil!');
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

            // Welcome bonus points!
            Point::create([
                'id_customer' => $customer->id_customer,
                'jumlah_point' => 50,
                'riwayat_transaksi' => 'Bonus Pendaftaran Member Baru Sportify',
            ]);

            session([
                'sportify_user_id' => $customer->id_customer,
                'sportify_user_role' => 'customer',
                'sportify_user_name' => $customer->nama,
                'sportify_user_email' => $customer->email,
            ]);

            return redirect()->route('home')->with('success', 'Pendaftaran berhasil! Anda mendapatkan bonus 50 Poin Loyalitas Sportify!');
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
