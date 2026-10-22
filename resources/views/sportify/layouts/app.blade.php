<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sportify - Sistem Pemesanan Lapangan Futsal & Olahraga')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sport: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
                        },
                        dark: {
                            800: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .gradient-sport {
            background: linear-gradient(135deg, #059669 0%, #10b981 50%, #064e3b 100%);
        }
        .gradient-dark {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }
    </style>
    @stack('styles')
</head>
<body class="flex flex-col min-h-full font-sans text-slate-800 antialiased selection:bg-sport-500 selection:text-white">

    <!-- Top Quick Demo Role Switcher Bar for Presentation / Testing -->
    <div class="bg-dark-900 border-b border-slate-800 text-xs text-slate-300 py-1.5 px-4 hidden md:block">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                    <i class="fa-solid fa-flask-vial mr-1"></i> DEMO MODE UNILA
                </span>
                <span>Proyek Praktikum Pemrograman Web Lanjut (Reggy Desvita Kamal - 2417051016)</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-slate-400">Login Cepat:</span>
                <a href="{{ route('demo.login', 'customer') }}" class="px-2 py-0.5 rounded bg-slate-800 hover:bg-sport-600 hover:text-white transition font-medium text-emerald-400 border border-slate-700">
                    <i class="fa-solid fa-user mr-1"></i> Customer
                </a>
                <a href="{{ route('demo.login', 'pemilik') }}" class="px-2 py-0.5 rounded bg-slate-800 hover:bg-sport-600 hover:text-white transition font-medium text-blue-400 border border-slate-700">
                    <i class="fa-solid fa-store mr-1"></i> Pemilik Lapangan
                </a>
                <a href="{{ route('demo.login', 'admin') }}" class="px-2 py-0.5 rounded bg-slate-800 hover:bg-sport-600 hover:text-white transition font-medium text-purple-400 border border-slate-700">
                    <i class="fa-solid fa-shield-halved mr-1"></i> Admin
                </a>
                @if(session()->has('sportify_user_id'))
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-rose-400 hover:text-rose-300 px-1.5 py-0.5 transition font-medium">
                            <i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Keluar
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header x-data="{ mobileOpen: false }" class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-sm transition">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-sport-600 to-sport-400 flex items-center justify-center text-white shadow-md shadow-sport-500/20 group-hover:scale-105 transition-transform duration-300">
                            <i class="fa-solid fa-futbol text-xl"></i>
                        </div>
                        <div>
                            <span class="font-display font-extrabold text-2xl tracking-tight text-slate-900 group-hover:text-sport-600 transition">
                                SPORT<span class="text-sport-500">IFY</span>
                            </span>
                            <span class="block text-[10px] font-semibold text-slate-600 tracking-wider uppercase -mt-1">
                                Futsal & Sports Center
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center space-x-1 lg:space-x-2">
                    <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold {{ request()->routeIs('home') ? 'bg-sport-50 text-sport-700 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }} transition">
                        <i class="fa-solid fa-magnifying-glass mr-1.5 text-sport-500"></i> Cari Lapangan
                    </a>
                    <a href="{{ route('rewards.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold {{ request()->routeIs('rewards.index') ? 'bg-sport-50 text-sport-700 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }} transition">
                        <i class="fa-solid fa-gift mr-1.5 text-amber-500"></i> Reward & Poin
                    </a>

                    @if(session('sportify_user_role') === 'customer')
                        <a href="{{ route('customer.bookings') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold {{ request()->routeIs('customer.bookings') ? 'bg-sport-50 text-sport-700 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }} transition">
                            <i class="fa-solid fa-calendar-check mr-1.5 text-blue-500"></i> Pesanan Saya
                        </a>
                    @elseif(session('sportify_user_role') === 'pemilik')
                        <a href="{{ route('pemilik.dashboard') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                            <i class="fa-solid fa-gauge-high mr-1.5"></i> Dashboard Pemilik
                        </a>
                        <a href="{{ route('pemilik.lapangan.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition">
                            <i class="fa-solid fa-layer-group mr-1.5"></i> Lapangan Saya
                        </a>
                        <a href="{{ route('pemilik.bookings') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition">
                            <i class="fa-solid fa-file-invoice-dollar mr-1.5"></i> Verifikasi Pesanan
                        </a>
                    @elseif(session('sportify_user_role') === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold bg-purple-50 text-purple-700 hover:bg-purple-100 transition">
                            <i class="fa-solid fa-shield-halved mr-1.5"></i> Admin Dashboard
                        </a>
                        <a href="{{ route('admin.lapangan') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition">
                            <i class="fa-solid fa-check-double mr-1.5"></i> Verifikasi Lapangan
                        </a>
                    @endif

                    <a href="{{ route('about') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold {{ request()->routeIs('about') ? 'bg-sport-50 text-sport-700 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }} transition">
                        <i class="fa-solid fa-users mr-1.5 text-slate-500"></i> Tim Pengembang
                    </a>
                </nav>

                <!-- Right Side User Menu / Auth Buttons -->
                <div class="hidden md:flex items-center space-x-3">
                    @if(session()->has('sportify_user_id'))
                        @php
                            $role = session('sportify_user_role');
                            $user = \App\Helpers\Sportify::user();
                            $points = ($role === 'customer' && $user) ? $user->total_poin : 0;
                        @endphp

                        @if($role === 'customer')
                            <a href="{{ route('rewards.index') }}" class="inline-flex items-center px-3 py-1.5 rounded-full bg-gradient-to-r from-amber-50 to-amber-100/80 border border-amber-200 text-amber-800 text-xs font-bold hover:scale-105 transition shadow-sm">
                                <i class="fa-solid fa-coins text-amber-500 mr-1.5 text-sm animate-pulse"></i>
                                <span>{{ $points }} Poin</span>
                            </a>
                        @endif

                        <!-- User Profile Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" type="button" class="flex items-center space-x-2.5 p-1.5 pl-3 pr-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200/80 transition focus:outline-none">
                                <div class="w-8 h-8 rounded-xl flex items-center justify-center font-bold text-xs text-white shadow-sm {{ $role === 'admin' ? 'bg-purple-600' : ($role === 'pemilik' ? 'bg-blue-600' : 'bg-sport-600') }}">
                                    {{ strtoupper(substr(session('sportify_user_name', 'U'), 0, 1)) }}
                                </div>
                                <div class="text-left leading-tight hidden lg:block">
                                    <span class="block text-xs font-bold text-slate-900 max-w-[120px] truncate">
                                        {{ session('sportify_user_name') }}
                                    </span>
                                    <span class="block text-[10px] font-semibold text-slate-600 uppercase">
                                        {{ $role }}
                                    </span>
                                </div>
                                <i class="fa-solid fa-chevron-down text-slate-400 text-xs"></i>
                            </button>

                            <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 animate-in fade-in zoom-in-95 duration-100">
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="text-xs text-slate-600 font-medium">Masuk sebagai:</p>
                                    <p class="text-sm font-bold text-slate-900 truncate">{{ session('sportify_user_name') }}</p>
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded-md mt-1 {{ $role === 'admin' ? 'bg-purple-100 text-purple-700' : ($role === 'pemilik' ? 'bg-blue-100 text-blue-700' : 'bg-sport-100 text-sport-700') }}">
                                        {{ ucfirst($role) }}
                                    </span>
                                </div>

                                @if($role === 'customer')
                                    <a href="{{ route('customer.bookings') }}" class="flex items-center px-4 py-2.5 text-xs text-slate-700 hover:bg-slate-50 font-medium">
                                        <i class="fa-solid fa-calendar-days text-slate-400 mr-2.5 w-4"></i> Riwayat Booking
                                    </a>
                                    <a href="{{ route('rewards.index') }}" class="flex items-center px-4 py-2.5 text-xs text-slate-700 hover:bg-slate-50 font-medium">
                                        <i class="fa-solid fa-gift text-slate-400 mr-2.5 w-4"></i> Katalog Hadiah Poin
                                    </a>
                                @elseif($role === 'pemilik')
                                    <a href="{{ route('pemilik.dashboard') }}" class="flex items-center px-4 py-2.5 text-xs text-slate-700 hover:bg-slate-50 font-medium">
                                        <i class="fa-solid fa-gauge text-slate-400 mr-2.5 w-4"></i> Dashboard Pemilik
                                    </a>
                                    <a href="{{ route('pemilik.lapangan.index') }}" class="flex items-center px-4 py-2.5 text-xs text-slate-700 hover:bg-slate-50 font-medium">
                                        <i class="fa-solid fa-futbol text-slate-400 mr-2.5 w-4"></i> Kelola Lapangan
                                    </a>
                                    <a href="{{ route('pemilik.slots') }}" class="flex items-center px-4 py-2.5 text-xs text-slate-700 hover:bg-slate-50 font-medium">
                                        <i class="fa-solid fa-clock text-slate-400 mr-2.5 w-4"></i> Atur Slot Jadwal
                                    </a>
                                @elseif($role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 text-xs text-slate-700 hover:bg-slate-50 font-medium">
                                        <i class="fa-solid fa-chart-pie text-slate-400 mr-2.5 w-4"></i> Admin Panel
                                    </a>
                                    <a href="{{ route('admin.lapangan') }}" class="flex items-center px-4 py-2.5 text-xs text-slate-700 hover:bg-slate-50 font-medium">
                                        <i class="fa-solid fa-check-to-slot text-slate-400 mr-2.5 w-4"></i> Verifikasi Lapangan
                                    </a>
                                    <a href="{{ route('admin.rewards') }}" class="flex items-center px-4 py-2.5 text-xs text-slate-700 hover:bg-slate-50 font-medium">
                                        <i class="fa-solid fa-gifts text-slate-400 mr-2.5 w-4"></i> Kelola Hadiah
                                    </a>
                                @endif

                                <div class="border-t border-slate-100 my-1"></div>

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-4 py-2.5 text-xs text-rose-600 hover:bg-rose-50 font-semibold transition">
                                        <i class="fa-solid fa-arrow-right-from-bracket mr-2.5 w-4"></i> Keluar (Logout)
                                    </button>
                                </form>
                            </div>
                        </div>

                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-700 hover:text-sport-600 hover:bg-slate-100 transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold bg-sport-600 hover:bg-sport-700 text-white shadow-md shadow-sport-600/30 transition transform hover:-translate-y-0.5">
                            Daftar Akun
                        </a>
                    @endif
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button @click="mobileOpen = !mobileOpen" type="button" class="p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none">
                        <i :class="mobileOpen ? 'fa-solid fa-xmark text-xl' : 'fa-solid fa-bars text-xl'"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileOpen" x-cloak class="md:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-6 space-y-3">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-sport-50 hover:text-sport-700">
                <i class="fa-solid fa-magnifying-glass mr-2 text-sport-500"></i> Cari Lapangan
            </a>
            <a href="{{ route('rewards.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-sport-50 hover:text-sport-700">
                <i class="fa-solid fa-gift mr-2 text-amber-500"></i> Reward & Poin
            </a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-sport-50 hover:text-sport-700">
                <i class="fa-solid fa-users mr-2 text-slate-500"></i> Tim Pengembang UNILA
            </a>

            @if(session()->has('sportify_user_id'))
                <div class="pt-2 border-t border-slate-100 space-y-1">
                    <div class="px-3 py-2 bg-slate-50 rounded-xl mb-2">
                        <p class="text-xs text-slate-600">Masuk sebagai:</p>
                        <p class="text-sm font-bold text-slate-900">{{ session('sportify_user_name') }} ({{ ucfirst(session('sportify_user_role')) }})</p>
                    </div>

                    @if(session('sportify_user_role') === 'customer')
                        <a href="{{ route('customer.bookings') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-100">
                            <i class="fa-solid fa-calendar-days mr-2"></i> Pesanan Saya
                        </a>
                    @elseif(session('sportify_user_role') === 'pemilik')
                        <a href="{{ route('pemilik.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-100">
                            <i class="fa-solid fa-gauge mr-2"></i> Dashboard Pemilik
                        </a>
                    @elseif(session('sportify_user_role') === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-100">
                            <i class="fa-solid fa-shield mr-2"></i> Dashboard Admin
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50 rounded-lg">
                            <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Keluar
                        </button>
                    </form>
                </div>
            @else
                <div class="pt-2 border-t border-slate-100 flex flex-col space-y-2">
                    <a href="{{ route('login') }}" class="w-full py-2.5 text-center rounded-xl font-bold text-slate-800 bg-slate-100 hover:bg-slate-200">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="w-full py-2.5 text-center rounded-xl font-bold text-white bg-sport-600 hover:bg-sport-700">
                        Daftar Akun Baru
                    </a>
                </div>
            @endif
        </div>
    </header>

    <!-- Global Alert / Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" class="mb-4 flex items-center justify-between p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 shadow-sm animate-in fade-in duration-300">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-bold">
                        <i class="fa-solid fa-circle-check text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold">Berhasil!</h4>
                        <p class="text-xs text-emerald-700">{{ session('success') }}</p>
                    </div>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-800 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" class="mb-4 flex items-center justify-between p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 shadow-sm animate-in fade-in duration-300">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-rose-500 text-white flex items-center justify-center font-bold">
                        <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold">Terjadi Kesalahan!</h4>
                        <p class="text-xs text-rose-700">{{ session('error') }}</p>
                    </div>
                </div>
                <button @click="show = false" class="text-rose-500 hover:text-rose-800 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div x-data="{ show: true }" x-show="show" class="mb-4 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 shadow-sm">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold flex-shrink-0">
                            <i class="fa-solid fa-circle-exclamation text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold">Periksa input Anda:</h4>
                            <ul class="text-xs text-amber-800 list-disc list-inside mt-1 space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button @click="show = false" class="text-amber-500 hover:text-amber-800 p-1">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark-900 text-slate-300 border-t border-slate-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                
                <!-- Brand Info -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-sport-500 flex items-center justify-center text-white font-bold text-lg">
                            <i class="fa-solid fa-futbol"></i>
                        </div>
                        <span class="font-display font-extrabold text-2xl tracking-tight text-white">
                            SPORT<span class="text-sport-400">IFY</span>
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed max-w-md">
                        Sistem Pemesanan Lapangan Futsal & Olahraga terintegrasi berbasis web dengan fitur pencegahan double booking, manajemen slot jadwal, verifikasi bukti pembayaran, serta program loyalitas poin dan reward.
                    </p>
                    <div class="p-3.5 rounded-2xl bg-slate-800/60 border border-slate-700/60 max-w-md">
                        <p class="text-[11px] font-bold text-sport-400 mb-1 flex items-center">
                            <i class="fa-solid fa-graduation-cap mr-1.5"></i> Mata Kuliah Pemrograman Web Lanjut
                        </p>
                        <p class="text-[11px] text-slate-300">
                            Jurusan Ilmu Komputer, FMIPA, Universitas Lampung (UNILA)
                        </p>
                    </div>
                </div>

                <!-- Tim Pengembang (Per Proposal PDF) -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4 flex items-center">
                        <i class="fa-solid fa-users text-sport-400 mr-2"></i> Tim Pengembang
                    </h4>
                    <ul class="space-y-2.5 text-xs text-slate-300">
                        <li class="flex items-center justify-between border-b border-slate-800/80 pb-1.5">
                            <span class="font-semibold text-white">Reggy Desvita Kamal</span>
                            <span class="font-mono text-[11px] text-slate-400">2417051016</span>
                        </li>
                        <li class="flex items-center justify-between border-b border-slate-800/80 pb-1.5">
                            <span>Elsy Aliffia Sirony Putri</span>
                            <span class="font-mono text-[11px] text-slate-400">2417051025</span>
                        </li>
                        <li class="flex items-center justify-between border-b border-slate-800/80 pb-1.5">
                            <span>Nur Ramadhani</span>
                            <span class="font-mono text-[11px] text-slate-400">2417051067</span>
                        </li>
                        <li class="flex items-center justify-between">
                            <span>Muhammad Rafi Al Musthafa</span>
                            <span class="font-mono text-[11px] text-slate-400">2457051009</span>
                        </li>
                    </ul>
                </div>

                <!-- Tautan Cepat -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4 flex items-center">
                        <i class="fa-solid fa-link text-sport-400 mr-2"></i> Menu Cepat
                    </h4>
                    <ul class="space-y-2 text-xs">
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-sport-400 transition flex items-center">
                                <i class="fa-solid fa-angle-right text-[10px] mr-2 text-slate-500"></i> Cari Lapangan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('rewards.index') }}" class="hover:text-sport-400 transition flex items-center">
                                <i class="fa-solid fa-angle-right text-[10px] mr-2 text-slate-500"></i> Katalog Hadiah Poin
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="hover:text-sport-400 transition flex items-center">
                                <i class="fa-solid fa-angle-right text-[10px] mr-2 text-slate-500"></i> Tentang Sportify
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('login') }}" class="hover:text-sport-400 transition flex items-center">
                                <i class="fa-solid fa-angle-right text-[10px] mr-2 text-slate-500"></i> Masuk / Daftar
                            </a>
                        </li>
                        <li>
                            <a href="/user" class="hover:text-sport-400 transition flex items-center text-slate-400">
                                <i class="fa-solid fa-code text-[10px] mr-2 text-slate-600"></i> Praktikum Modul 1-6
                            </a>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="mt-12 pt-6 border-t border-slate-800 flex flex-col md:flex-row items-center justify-between text-xs text-slate-400">
                <p>&copy; {{ date('Y') }} SPORTIFY - Sistem Pemesanan Lapangan Futsal & Olahraga. All rights reserved.</p>
                <p class="mt-2 md:mt-0 flex items-center">
                    Dibuat dengan <i class="fa-solid fa-heart text-rose-500 mx-1.5"></i> menggunakan Laravel 12, PostgreSQL & Tailwind CSS
                </p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
