@extends('sportify.layouts.app')

@section('title', 'Daftar Akun Sportify')

@section('content')
<div class="py-14 sm:py-20 bg-slate-50 min-h-[80vh] flex items-center justify-center">
    <div class="max-w-md w-full mx-4" x-data="{ role: '{{ old('role', 'customer') }}' }">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-sport-600 to-sport-400 flex items-center justify-center text-white text-2xl shadow-lg shadow-sport-500/30 mx-auto mb-4">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                Bergabung dengan SPORTIFY
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Daftar sebagai Pelanggan atau Daftarkan Lapangan Olahraga Anda
            </p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xl p-6 sm:p-8">
            
            <!-- Role Toggle -->
            <div class="flex p-1 bg-slate-100 rounded-2xl mb-6">
                <button type="button" 
                        @click="role = 'customer'" 
                        :class="role === 'customer' ? 'bg-white text-sport-700 shadow-sm font-bold' : 'text-slate-600 font-semibold'" 
                        class="flex-1 py-2 text-xs rounded-xl transition text-center">
                    <i class="fa-solid fa-user mr-1"></i> Pelanggan
                </button>
                <button type="button" 
                        @click="role = 'pemilik'" 
                        :class="role === 'pemilik' ? 'bg-white text-blue-700 shadow-sm font-bold' : 'text-slate-600 font-semibold'" 
                        class="flex-1 py-2 text-xs rounded-xl transition text-center">
                    <i class="fa-solid fa-store mr-1"></i> Pemilik Lapangan
                </button>
            </div>

            <!-- Customer Promo Note -->
            <div x-show="role === 'customer'" class="mb-5 p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs flex items-center space-x-2">
                <i class="fa-solid fa-gift text-amber-500 text-sm"></i>
                <span>Daftar sekarang dan dapatkan bonus langsung <strong class="font-bold">50 Poin Loyalitas</strong>!</span>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="role" :value="role">

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5" x-text="role === 'pemilik' ? 'Nama Pemilik / Nama Usaha:' : 'Nama Lengkap:'"></label>
                    <div class="relative">
                        <i class="fa-solid fa-id-card absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Budi Santoso"
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-sport-500 focus:border-sport-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Email:</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-sport-500 focus:border-sport-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor WhatsApp (No HP):</label>
                    <div class="relative">
                        <i class="fa-brands fa-whatsapp absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" name="no_wa" value="{{ old('no_wa') }}" required placeholder="08123456789"
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-sport-500 focus:border-sport-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi (Password):</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="password" name="password" required placeholder="Minimal 6 karakter"
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-sport-500 focus:border-sport-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Konfirmasi Kata Sandi:</label>
                    <div class="relative">
                        <i class="fa-solid fa-shield-check absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="password" name="password_confirmation" required placeholder="Ulangi kata sandi"
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-sport-500 focus:border-sport-500">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 px-4 rounded-xl bg-sport-600 hover:bg-sport-700 text-white font-bold text-xs tracking-wider uppercase shadow-md shadow-sport-600/30 transition">
                        Daftarkan Akun <i class="fa-solid fa-arrow-right ml-1.5"></i>
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-500">
                    Sudah memiliki akun? 
                    <a href="{{ route('login') }}" class="font-bold text-sport-600 hover:text-sport-700">Masuk di sini</a>
                </p>
            </div>

        </div>

    </div>
</div>
@endsection
