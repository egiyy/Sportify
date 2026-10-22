@extends('sportify.layouts.app')

@section('title', 'Ulasan Pelanggan - Pemilik Lapangan')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('pemilik.dashboard') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition mb-1 inline-block">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Dashboard Pemilik
                </a>
                <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                    Ulasan & Tanggapan Pelanggan
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Baca pengalaman pelanggan setelah bermain di lapangan Anda dan kirimkan respon resmi.
                </p>
            </div>
        </div>

        @if($ulasans->isEmpty())
            <div class="text-center py-16 bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
                <i class="fa-regular fa-comment-dots text-4xl text-slate-300 mb-3"></i>
                <h3 class="font-bold text-sm text-slate-800">Belum ada ulasan</h3>
                <p class="text-xs text-slate-500 mt-1">Ulasan akan muncul di sini setelah pelanggan menyelesaikan permainan.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($ulasans as $u)
                    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 space-y-4">
                        
                        <div class="flex items-start justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full bg-sport-100 text-sport-700 flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr($u->customer->nama ?? 'P', 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm text-slate-900">{{ $u->customer->nama }}</h4>
                                    <span class="text-[11px] text-slate-500">
                                        Lapangan: <strong class="text-slate-800">{{ $u->lapangan->nama_lapangan }}</strong>
                                        &bull; {{ $u->created_at->translatedFormat('d F Y, H:i') }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center text-amber-400 text-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= $u->rating ? 'text-amber-400' : 'text-slate-200' }}"></i>
                                @endfor
                                <span class="ml-1.5 font-bold text-slate-800 text-xs">{{ $u->rating }}.0</span>
                            </div>
                        </div>

                        <div class="pl-13 text-xs text-slate-700 leading-relaxed italic bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            "{{ $u->komentar }}"
                        </div>

                        <!-- Existing Reply or Reply Form -->
                        @if($u->balasan_pemilik)
                            <div class="pl-6 border-l-2 border-blue-500 py-1 space-y-1">
                                <div class="flex items-center space-x-2 text-xs font-bold text-blue-900">
                                    <i class="fa-solid fa-reply fa-rotate-180 text-blue-500"></i>
                                    <span>Tanggapan Anda ({{ $u->tanggal_balasan?->translatedFormat('d M Y') }}):</span>
                                </div>
                                <p class="text-xs text-slate-700 leading-relaxed">
                                    {{ $u->balasan_pemilik }}
                                </p>
                            </div>
                        @else
                            <form action="{{ route('pemilik.ulasan.reply', $u->id_ulasan) }}" method="POST" class="pt-2 flex items-center gap-2">
                                @csrf
                                <input type="text" name="balasan_pemilik" required placeholder="Tulis tanggapan / terima kasih untuk pelanggan..."
                                       class="flex-1 px-4 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-sport-500 focus:outline-none">
                                <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-sm transition whitespace-nowrap">
                                    <i class="fa-solid fa-paper-plane mr-1"></i> Balas
                                </button>
                            </form>
                        @endif

                    </div>
                @endforeach

                <div class="pt-4">
                    {{ $ulasans->links() }}
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
