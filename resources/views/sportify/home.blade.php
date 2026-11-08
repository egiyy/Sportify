@extends('sportify.layouts.app')

@section('title', 'Sportify - Sewa & Booking Lapangan Olahraga Mudah & Cepat')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-dark-950 text-white py-16 lg:py-24">
    <!-- Ambient Background Lighting -->
    <div class="absolute inset-0 z-0">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-sport-500/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-emerald-600/20 rounded-full blur-3xl"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:16px_16px] opacity-30"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Hero Content -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full bg-sport-500/10 border border-sport-500/30 text-sport-400 text-xs font-bold tracking-wide">
                    <span class="w-2 h-2 rounded-full bg-sport-400 animate-ping"></span>
                    <span>Platform Sewa Lapangan Futsal & Olahraga #1</span>
                </div>

                <h1 class="font-display font-extrabold text-4xl sm:text-5xl lg:text-6xl tracking-tight leading-tight">
                    Main Olahraga Tanpa Ribet, <span class="text-transparent bg-clip-text bg-gradient-to-r from-sport-400 via-emerald-300 to-teal-200">Bebas Double Booking!</span>
                </h1>

                <p class="text-slate-300 text-base sm:text-lg leading-relaxed max-w-2xl mx-auto lg:mx-0 font-normal">
                    Cek ketersediaan slot jam secara real-time, pesan instan, unggah bukti bayar mudah, dan kumpulkan <strong class="text-amber-400 font-semibold">Poin Loyalitas</strong> untuk ditukar hadiah minuman & merchandise keren!
                </p>

                <!-- Search & Filter Form -->
                <div class="pt-2">
                    <form action="{{ route('home') }}" method="GET" class="bg-white/10 p-2 sm:p-2.5 rounded-2xl backdrop-blur-md border border-white/20 shadow-2xl flex flex-col sm:flex-row items-center gap-2 max-w-2xl mx-auto lg:mx-0">
                        <div class="relative flex-grow w-full">
                            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari nama lapangan, futsal, atau lokasi..." 
                                class="w-full pl-11 pr-4 py-3 bg-white text-slate-900 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sport-500 placeholder:text-slate-400">
                        </div>

                      <select name="sport" class="w-full sm:w-auto px-4 py-3 bg-white text-slate-800 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-sport-500 border-0">
    <option value="semua" {{ !($sport ?? null) || $sport === 'semua' ? 'selected' : '' }}>
        Semua Olahraga
    </option>
    <option value="futsal" {{ ($sport ?? '') === 'futsal' ? 'selected' : '' }}>⚽ Futsal</option>
    <option value="badminton" {{ ($sport ?? '') === 'badminton' ? 'selected' : '' }}>🏸 Badminton</option>
    <option value="basket" {{ ($sport ?? '') === 'basket' ? 'selected' : '' }}>🏀 Basket</option>
    <option value="voli" {{ ($sport ?? '') === 'voli' ? 'selected' : '' }}>🏐 Voli</option>
</select>

                        <button type="submit" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-sport-500 hover:bg-sport-600 text-white font-bold text-sm shadow-lg shadow-sport-500/40 transition whitespace-nowrap">
                            <i class="fa-solid fa-bolt mr-1.5"></i> Temukan Lapangan
                        </button>
                    </form>
                </div>

             <!-- Sport Category Pills -->
<div class="flex flex-wrap items-center justify-center lg:justify-start gap-2 pt-2">
    <span class="text-xs text-slate-400 font-semibold mr-1">Kategori:</span>

    <a href="{{ route('home', ['sport' => 'semua', 'q' => request('q')]) }}"
       class="px-3 py-1 rounded-xl text-xs font-bold {{ !request('sport') || request('sport') === 'semua' ? 'bg-sport-500 text-white' : 'bg-slate-800/80 text-slate-300 hover:bg-slate-700' }} transition">
        Semua
    </a>

    <a href="{{ route('home', ['sport' => 'futsal', 'q' => request('q')]) }}"
       class="px-3 py-1 rounded-xl text-xs font-bold {{ request('sport') === 'futsal' ? 'bg-sport-500 text-white' : 'bg-slate-800/80 text-slate-300 hover:bg-slate-700' }} transition">
        ⚽ Futsal
    </a>

    <a href="{{ route('home', ['sport' => 'badminton', 'q' => request('q')]) }}"
       class="px-3 py-1 rounded-xl text-xs font-bold {{ request('sport') === 'badminton' ? 'bg-sport-500 text-white' : 'bg-slate-800/80 text-slate-300 hover:bg-slate-700' }} transition">
        🏸 Badminton
    </a>

    <a href="{{ route('home', ['sport' => 'basket', 'q' => request('q')]) }}"
       class="px-3 py-1 rounded-xl text-xs font-bold {{ request('sport') === 'basket' ? 'bg-sport-500 text-white' : 'bg-slate-800/80 text-slate-300 hover:bg-slate-700' }} transition">
        🏀 Basket
    </a>

    <a href="{{ route('home', ['sport' => 'voli', 'q' => request('q')]) }}"
       class="px-3 py-1 rounded-xl text-xs font-bold {{ request('sport') === 'voli' ? 'bg-sport-500 text-white' : 'bg-slate-800/80 text-slate-300 hover:bg-slate-700' }} transition">
        🏐 Voli
    </a>
</div>

           </div> <!-- Right Hero Card / Visual -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-md bg-gradient-to-b from-slate-800/90 to-slate-900/95 p-6 rounded-3xl border border-slate-700 shadow-2xl backdrop-blur-xl">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-700/80">
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                            <span class="w-3 h-3 rounded-full bg-sport-500"></span>
                        </div>
                        <span class="text-xs font-bold tracking-wider text-sport-400 uppercase">Jadwal Live Hari Ini</span>
                    </div>

                    <div class="mt-4 space-y-3">
                        <div class="p-3.5 rounded-2xl bg-slate-800/80 border border-slate-700 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-sport-500/20 text-sport-400 flex items-center justify-center font-bold">
                                    ⚽
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-white">Champion Futsal Sintetis</h4>
                                    <p class="text-[11px] text-slate-400">19:00 - 20:00 WIB</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-sport-500/20 text-sport-400 border border-sport-500/30">
                                TERSEDIA
                            </span>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-slate-800/80 border border-slate-700 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center font-bold">
                                    🏸
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-white">Golden Badminton Court 1</h4>
                                    <p class="text-[11px] text-slate-400">20:00 - 21:00 WIB</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-rose-500/20 text-rose-400 border border-rose-500/30">
                                DIBOOKING
                            </span>
                        </div>

                        <!-- Mini Loyalty Points Promo Box -->
                        <div class="p-4 rounded-2xl bg-gradient-to-r from-amber-500/20 via-orange-500/10 to-transparent border border-amber-500/30">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-amber-500 text-slate-950 flex items-center justify-center font-bold text-sm">
                                        <i class="fa-solid fa-gift"></i>
                                    </div>
                                    <div>
                                        <h5 class="text-xs font-bold text-amber-300">Sistem Poin & Reward</h5>
                                        <p class="text-[10px] text-slate-300">Dapatkan hingga 100 poin tiap kali main!</p>
                                    </div>
                                </div>
                                <a href="{{ route('rewards.index') }}" class="px-2.5 py-1 rounded-lg bg-amber-500 text-slate-950 font-extrabold text-[10px] hover:bg-amber-400 transition">
                                    Tukar
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-800 flex items-center justify-between text-[11px] text-slate-400">
                        <span><i class="fa-solid fa-shield-check text-sport-400 mr-1"></i> Terverifikasi Admin</span>
                        <span><i class="fa-solid fa-receipt text-blue-400 mr-1"></i> Bukti Bayar Transparan</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Why Sportify Feature Grid -->
<section class="py-12 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="flex items-start space-x-4 p-5 rounded-2xl bg-slate-50 border border-slate-100 hover:shadow-md transition">
                <div class="w-12 h-12 rounded-2xl bg-sport-100 text-sport-600 flex items-center justify-center text-xl flex-shrink-0">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div>
                    <h3 class="font-bold text-base text-slate-900 mb-1">Bebas Double Booking</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Sistem database kami dilengkapi constraint unik per jam dan per lapangan, menjamin jadwal tidak akan pernah bentrok atau ganda.
                    </p>
                </div>
            </div>

            <div class="flex items-start space-x-4 p-5 rounded-2xl bg-slate-50 border border-slate-100 hover:shadow-md transition">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl flex-shrink-0">
                    <i class="fa-solid fa-coins"></i>
                </div>
                <div>
                    <h3 class="font-bold text-base text-slate-900 mb-1">Poin & Reward Gratis</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Setiap transaksi pemesanan yang selesai otomatis menghasilkan poin loyalitas. Tukar dengan minuman dingin, handuk, atau jersey!
                    </p>
                </div>
            </div>

            <div class="flex items-start space-x-4 p-5 rounded-2xl bg-slate-50 border border-slate-100 hover:shadow-md transition">
                <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl flex-shrink-0">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                </div>
                <div>
                    <h3 class="font-bold text-base text-slate-900 mb-1">Konfirmasi Pembayaran Cepat</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Unggah bukti transfer atau scan QRIS langsung dari HP. Pemilik lapangan memverifikasi pesanan secara transparan.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Fields Catalog Section -->
<section id="lapangan" class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10">
            <div>
                <span class="text-xs font-extrabold text-sport-600 tracking-wider uppercase mb-1 block">
                    PILIHAN TERBAIK DI BANDAR LAMPUNG
                </span>
                <h2 class="font-display font-extrabold text-3xl sm:text-4xl text-slate-900 tracking-tight">
                    Daftar Lapangan Olahraga
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Menampilkan {{ $lapangans->count() }} lapangan siap pakai dengan fasilitas lengkap.
                </p>
            </div>

            @if($search || ($sport && $sport !== 'semua'))
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-3.5 py-1.5 rounded-xl bg-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-300 transition">
                        <i class="fa-solid fa-rotate-left mr-1.5"></i> Reset Filter
                    </a>
                </div>
            @endif
        </div>

        @if($lapangans->isEmpty())
            <div class="text-center py-16 bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fa-solid fa-futbol"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800">Tidak ada lapangan yang cocok</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    Coba ganti kata kunci pencarian atau pilih kategori olahraga lainnya.
                </p>
                <a href="{{ route('home') }}" class="mt-4 inline-block px-4 py-2 rounded-xl bg-sport-600 text-white text-xs font-bold hover:bg-sport-700 transition">
                    Lihat Semua Lapangan
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($lapangans as $lapangan)
                    <div class="group bg-white rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-xl hover:border-sport-500/50 transition duration-300 flex flex-col overflow-hidden">
                        
                        <!-- Image & Badges -->
                        <div class="relative h-48 w-full overflow-hidden bg-slate-100">
                            <img src="{{ $lapangan->foto ?: 'https://images.unsplash.com/photo-1529900748604-07564a03e7a6?w=800&auto=format&fit=crop&q=80' }}" 
                                 alt="{{ $lapangan->nama_lapangan }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            <!-- Category Badge -->
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-extrabold bg-dark-900/80 backdrop-blur-md text-white border border-white/20 shadow-sm">
                                    @if(strtolower($lapangan->jenis_olahraga) === 'futsal')
                                        ⚽ Futsal
                                    @elseif(strtolower($lapangan->jenis_olahraga) === 'badminton')
                                        🏸 Badminton
                                   @elseif(strtolower($lapangan->jenis_olahraga) === 'basket')
    🏀 Basket
@elseif(strtolower($lapangan->jenis_olahraga) === 'voli')
    🏐 Voli
@else
    {{ $lapangan->jenis_olahraga }}
@endif
                                </span>
                            </div>

                            <!-- Rating Badge -->
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-bold bg-amber-400 text-slate-950 shadow-sm">
                                    <i class="fa-solid fa-star text-[10px] mr-1"></i>
{{ $lapangan->average_rating ? number_format((float) $lapangan->average_rating, 1) : 'Belum ada rating' }}
                                </span>
                            </div>

                            <!-- Price Tag Overlay -->
                            <div class="absolute bottom-3 right-3">
                                <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-sport-600 text-white shadow-md">
                                    {{ \App\Helpers\Sportify::rupiah($lapangan->harga_per_jam) }}/jam
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="font-display font-bold text-lg text-slate-900 group-hover:text-sport-600 transition leading-snug line-clamp-1">
                                    {{ $lapangan->nama_lapangan }}
                                </h3>

                                <p class="text-xs text-slate-500 mt-2 flex items-start line-clamp-2">
                                    <i class="fa-solid fa-location-dot text-rose-500 mr-2 mt-0.5 flex-shrink-0"></i>
                                    <span>{{ $lapangan->lokasi }}</span>
                                </p>

                                <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                                    <span>
                                        <i class="fa-solid fa-user-tie mr-1 text-slate-400"></i>
                                        {{ $lapangan->pemilik->nama_pemilik ?? 'Mitra Venue' }}
                                    </span>
                                    <span>
                                        <i class="fa-solid fa-comment-dots mr-1 text-slate-400"></i>
                                        {{ $lapangan->ulasan->count() }} Ulasan
                                    </span>
                                </div>
                            </div>

                            <div class="mt-5">
                                <a href="{{ route('lapangan.detail', $lapangan->id_lapangan) }}" class="w-full flex items-center justify-center py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-sport-600 text-white text-xs font-bold tracking-wide transition shadow-sm group-hover:shadow-sport-600/30">
                                    <span>Lihat Jadwal & Pesan</span>
                                    <i class="fa-solid fa-arrow-right ml-2 text-[10px]"></i>
                                </a>
                            </div>

                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </div>
</section>

<!-- Rewards Loyalty Highlight Section -->
<section class="py-16 bg-white border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="p-8 sm:p-12 rounded-3xl gradient-dark text-white relative overflow-hidden shadow-2xl">
            <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-amber-500/20 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-7 space-y-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 text-xs font-bold border border-amber-500/30">
                        <i class="fa-solid fa-gift mr-1.5"></i> SPORTIFY LOYALTY CLUB
                    </span>
                    <h2 class="font-display font-extrabold text-3xl sm:text-4xl tracking-tight">
                        Main Terus, Kumpulkan Poin, Dapatkan Hadiah Gratis!
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-xl">
                        Setiap kali pesananmu selesai, kamu akan langsung dihadiahi poin loyalitas. Tukarkan poinmu dengan minuman segar langsung di tempat, handuk, jersey edisi terbatas, atau voucher potongan sewa!
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('rewards.index') }}" class="inline-flex items-center px-6 py-3 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-slate-950 font-extrabold text-xs tracking-wider uppercase shadow-lg shadow-amber-500/30 transition transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-gifts mr-2 text-sm"></i> Buka Katalog Reward Sportify
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-5 grid grid-cols-2 gap-3">
                    @foreach($rewards->take(4) as $rew)
                        <div class="p-3 rounded-2xl bg-slate-800/80 border border-slate-700/80 text-center">
                            <img src="{{ $rew->foto }}" alt="{{ $rew->nama_reward }}" class="w-16 h-16 object-cover rounded-xl mx-auto mb-2">
                            <h4 class="text-xs font-bold text-white line-clamp-1">{{ $rew->nama_reward }}</h4>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 text-[10px] font-extrabold border border-amber-500/30">
                                {{ $rew->poin_dibutuhkan }} Poin
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
