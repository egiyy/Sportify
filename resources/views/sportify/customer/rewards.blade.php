@extends('sportify.layouts.app')

@section('title', 'Katalog Reward & Poin Loyalitas - Sportify')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <!-- Hero Balance Banner -->
        <div class="rounded-3xl gradient-dark text-white p-8 sm:p-12 relative overflow-hidden shadow-2xl border border-slate-800">
            <div class="absolute -right-16 -top-16 w-80 h-80 bg-amber-500/20 rounded-full blur-3xl"></div>
            <div class="absolute -left-16 -bottom-16 w-80 h-80 bg-sport-500/20 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                <div class="md:col-span-8 space-y-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 text-xs font-bold border border-amber-500/30">
                        <i class="fa-solid fa-crown mr-1.5 text-amber-400"></i> PROGRAM LOYALITAS SPORTIFY
                    </span>
                    <h1 class="font-display font-extrabold text-3xl sm:text-4xl text-white tracking-tight">
                        Tukarkan Poin dengan Minuman & Merchandise!
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-300 max-w-xl leading-relaxed">
                        Kumpulkan poin dari setiap pemesanan lapangan yang berhasil dan pemberian ulasan. Dapatkan minuman isotonik dingin gratis, handuk olahraga, jersey eksklusif, hingga voucher diskon sewa!
                    </p>
                </div>

                <div class="md:col-span-4 bg-slate-800/80 backdrop-blur-md rounded-2xl p-6 border border-slate-700/80 text-center shadow-inner">
                    @if(session()->has('sportify_user_id') && session('sportify_user_role') === 'customer')
                        <span class="text-xs text-slate-400 font-bold uppercase tracking-wider block mb-1">Saldo Poin Anda Saat Ini</span>
                        <div class="flex items-center justify-center space-x-2 my-2">
                            <i class="fa-solid fa-coins text-amber-400 text-3xl animate-bounce"></i>
                            <span class="font-display font-extrabold text-4xl text-amber-300">{{ $totalPoin }}</span>
                            <span class="text-xs text-slate-400 font-bold">POIN</span>
                        </div>
                        <p class="text-[11px] text-slate-300">
                            Member: <strong class="text-white">{{ session('sportify_user_name') }}</strong>
                        </p>
                    @else
                        <span class="text-xs text-slate-400 font-bold block mb-2">Ingin menukarkan hadiah?</span>
                        <p class="text-xs text-slate-300 mb-4">Masuk sebagai pelanggan untuk mengumpulkan dan menukarkan poin Anda.</p>
                        <a href="{{ route('demo.login', 'customer') }}" class="inline-block w-full py-2.5 px-4 rounded-xl bg-amber-400 hover:bg-amber-500 text-slate-950 font-bold text-xs tracking-wider uppercase transition shadow-md">
                            <i class="fa-solid fa-user mr-1.5"></i> Login Cepat Customer
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Rewards Catalog Grid -->
        <div>
            <div class="mb-6 flex flex-col sm:flex-row sm:items-end justify-between gap-2">
                <div>
                    <span class="text-xs font-bold text-sport-600 uppercase tracking-wider block">KATALOG TERSEDIA</span>
                    <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                        Pilihan Hadiah Reward
                    </h2>
                </div>
                <p class="text-xs text-slate-500">
                    Hadiah dapat langsung diambil di counter pengelola venue setelah penukaran.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($rewards as $reward)
                    @php
                        $canRedeem = (session('sportify_user_role') === 'customer' && $totalPoin >= $reward->poin_dibutuhkan && $reward->stok > 0);
                    @endphp

                    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden flex flex-col justify-between hover:border-amber-400 transition">
                        <div>
                            <div class="relative h-48 w-full bg-slate-100 overflow-hidden">
                                <img src="{{ $reward->foto ?: 'https://images.unsplash.com/photo-1560023907-5f339617ea30?w=600&auto=format&fit=crop&q=80' }}" 
                                     alt="{{ $reward->nama_reward }}" 
                                     class="w-full h-full object-cover">
                                
                                <div class="absolute top-3 right-3">
                                    <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-amber-400 text-slate-950 shadow-md flex items-center">
                                        <i class="fa-solid fa-coins mr-1 text-xs"></i> {{ $reward->poin_dibutuhkan }} Poin
                                    </span>
                                </div>

                                <div class="absolute bottom-3 left-3">
                                    <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-bold {{ $reward->stok > 0 ? 'bg-dark-900/80 text-white' : 'bg-rose-600 text-white' }}">
                                        Stok: {{ $reward->stok }} Tersedia
                                    </span>
                                </div>
                            </div>

                            <div class="p-5 space-y-2">
                                <h3 class="font-display font-bold text-base text-slate-900 leading-snug">
                                    {{ $reward->nama_reward }}
                                </h3>
                                <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">
                                    {{ $reward->deskripsi ?: 'Hadiah spesial untuk member setia Sportify.' }}
                                </p>
                            </div>
                        </div>

                        <div class="p-5 pt-0">
                            @if(session('sportify_user_role') === 'customer')
                                @if($canRedeem)
                                    <form action="{{ route('rewards.redeem', $reward->id_reward) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menukarkan {{ $reward->poin_dibutuhkan }} poin untuk {{ $reward->nama_reward }}?');">
                                        @csrf
                                        <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold text-xs tracking-wider uppercase transition shadow-md shadow-amber-500/20">
                                            <i class="fa-solid fa-gift mr-1.5"></i> Tukar Hadiah Ini
                                        </button>
                                    </form>
                                @elseif($reward->stok <= 0)
                                    <button disabled class="w-full py-2.5 px-4 rounded-xl bg-slate-100 text-slate-400 font-bold text-xs cursor-not-allowed border border-slate-200">
                                        Stok Hadiah Habis
                                    </button>
                                @else
                                    <button disabled class="w-full py-2.5 px-4 rounded-xl bg-slate-100 text-slate-400 font-bold text-xs cursor-not-allowed border border-slate-200">
                                        Butuh {{ $reward->poin_dibutuhkan - $totalPoin }} Poin Lagi
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="block text-center py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition border border-slate-200">
                                    Masuk untuk Menukar
                                </a>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        </div>

        <!-- Points & Redemptions History (If Logged In) -->
        @if(session()->has('sportify_user_id') && session('sportify_user_role') === 'customer')
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-6">
                
                <!-- Point Transaction Logs -->
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 space-y-4">
                    <h3 class="font-display font-bold text-base text-slate-900 pb-2 border-b border-slate-100 flex items-center justify-between">
                        <span class="flex items-center">
                            <i class="fa-solid fa-clock-rotate-left text-sport-500 mr-2"></i> Riwayat Mutasi Poin
                        </span>
                        <span class="text-xs text-slate-400 font-normal">10 Transaksi Terakhir</span>
                    </h3>

                    @if($pointsHistory->isEmpty())
                        <p class="text-xs text-slate-400 text-center py-6">Belum ada catatan mutasi poin.</p>
                    @else
                        <div class="space-y-2.5 max-h-80 overflow-y-auto pr-1">
                            @foreach($pointsHistory as $pt)
                                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between text-xs">
                                    <div>
                                        <h4 class="font-bold text-slate-900">{{ $pt->riwayat_transaksi }}</h4>
                                        <span class="text-[10px] text-slate-400">{{ $pt->created_at->translatedFormat('d M Y, H:i') }}</span>
                                    </div>
                                    <span class="font-extrabold text-sm {{ $pt->jumlah_point > 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $pt->jumlah_point > 0 ? '+' : '' }}{{ $pt->jumlah_point }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Redemptions List -->
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 space-y-4">
                    <h3 class="font-display font-bold text-base text-slate-900 pb-2 border-b border-slate-100 flex items-center justify-between">
                        <span class="flex items-center">
                            <i class="fa-solid fa-bag-shopping text-amber-500 mr-2"></i> Hadiah yang Pernah Ditukar
                        </span>
                        <span class="text-xs text-slate-400 font-normal">Klaim ke venue</span>
                    </h3>

                    @if($penukaranHistory->isEmpty())
                        <p class="text-xs text-slate-400 text-center py-6">Anda belum pernah menukarkan hadiah.</p>
                    @else
                        <div class="space-y-2.5 max-h-80 overflow-y-auto pr-1">
                            @foreach($penukaranHistory as $penukaran)
                                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between text-xs">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $penukaran->reward->foto }}" class="w-10 h-10 rounded-xl object-cover">
                                        <div>
                                            <h4 class="font-bold text-slate-900">{{ $penukaran->reward->nama_reward }}</h4>
                                            <span class="text-[10px] text-slate-400">{{ $penukaran->tanggal_tukar->translatedFormat('d M Y, H:i') }}</span>
                                        </div>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800">
                                        {{ ucfirst($penukaran->status_penukaran) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        @endif

    </div>
</div>
@endsection
