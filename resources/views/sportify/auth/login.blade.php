@extends('sportify.layouts.app')

@section('title', 'Masuk ke Sportify')

@section('content')
<div class="py-14 sm:py-20 bg-slate-50 min-h-[80vh] flex items-center justify-center">
    <div class="max-w-md w-full mx-4" x-data="{ currentRole: '{{ old('role', 'customer') }}' }">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-sport-600 to-sport-400 flex items-center justify-center text-white text-2xl shadow-lg shadow-sport-500/30 mx-auto mb-4">
                <i class="fa-solid fa-futbol"></i>
            </div>
            <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                Selamat Datang di SPORTIFY
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Sistem Pemesanan Lapangan Futsal & Olahraga Terpadu
            </p>
        </div>

        <!-- Quick Demo Login Buttons Bar -->
        <div class="mb-6 p-4 rounded-2xl bg-gradient-to-r from-slate-900 to-dark-800 text-white shadow-md border border-slate-700">
            <div class="flex items-center justify-between mb-2.5">
                <span class="text-[11px] font-bold text-amber-300 uppercase tracking-wider flex items-center">
                    <i class="fa-solid fa-bolt mr-1.5 text-amber-400"></i> Mode Demo Evaluasi (1-Klik Masuk)
                </span>
                <span class="text-[10px] text-slate-400">Pilih role:</span>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <a href="{{ route('demo.login', 'customer') }}" class="py-2 px-2 rounded-xl bg-slate-800 hover:bg-sport-600 transition text-center text-xs font-bold text-emerald-300 border border-slate-700 flex flex-col items-center">
                    <i class="fa-solid fa-user text-sm mb-1 text-emerald-400"></i>
                    <span>Customer</span>
                </a>
                <a href="{{ route('demo.login', 'pemilik') }}" class="py-2 px-2 rounded-xl bg-slate-800 hover:bg-blue-600 transition text-center text-xs font-bold text-blue-300 border border-slate-700 flex flex-col items-center">
                    <i class="fa-solid fa-store text-sm mb-1 text-blue-400"></i>
                    <span>Pemilik</span>
                </a>
                <a href="{{ route('demo.login', 'admin') }}" class="py-2 px-2 rounded-xl bg-slate-800 hover:bg-purple-600 transition text-center text-xs font-bold text-purple-300 border border-slate-700 flex flex-col items-center">
                    <i class="fa-solid fa-shield-halved text-sm mb-1 text-purple-400"></i>
                    <span>Admin</span>
                </a>
            </div>
        </div>

        <!-- Login Form Card -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xl p-6 sm:p-8">
            
            <!-- Role Selector Tabs -->
            <div class="flex p-1 bg-slate-100 rounded-2xl mb-6">
                <button type="button" 
                        @click="currentRole = 'customer'" 
                        :class="currentRole === 'customer' ? 'bg-white text-sport-700 shadow-sm font-bold' : 'text-slate-600 font-semibold'" 
                        class="flex-1 py-2 text-xs rounded-xl transition text-center">
                    Pelanggan
                </button>
                <button type="button" 
                        @click="currentRole = 'pemilik'" 
                        :class="currentRole === 'pemilik' ? 'bg-white text-blue-700 shadow-sm font-bold' : 'text-slate-600 font-semibold'" 
                        class="flex-1 py-2 text-xs rounded-xl transition text-center">
                    Pemilik Venue
                </button>
                <button type="button" 
                        @click="currentRole = 'admin'" 
                        :class="currentRole === 'admin' ? 'bg-white text-purple-700 shadow-sm font-bold' : 'text-slate-600 font-semibold'" 
                        class="flex-1 py-2 text-xs rounded-xl transition text-center">
                    Admin
                </button>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="role" :value="currentRole">

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Email:</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-sport-500 focus:border-sport-500">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-slate-700">Kata Sandi:</label>
                    </div>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="password" name="password" required placeholder="••••••••"
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-sport-500 focus:border-sport-500">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 px-4 rounded-xl bg-sport-600 hover:bg-sport-700 text-white font-bold text-xs tracking-wider uppercase shadow-md shadow-sport-600/30 transition">
                        Masuk Sekarang <i class="fa-solid fa-arrow-right-to-bracket ml-1.5"></i>
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-500">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-bold text-sport-600 hover:text-sport-700">Daftar Akun Baru</a>
                </p>
            </div>

        </div>

    </div>
</div>
@endsection
