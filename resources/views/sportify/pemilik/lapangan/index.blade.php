@extends('sportify.layouts.app')

@section('title', 'Kelola Lapangan Saya - Sportify')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('pemilik.dashboard') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition mb-1 inline-block">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Dashboard Pemilik
                </a>
                <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                    Daftar Lapangan Olahraga Saya
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Kelola data lapangan, jenis olahraga, tarif per jam, dan fasilitas venue Anda.
                </p>
            </div>

            <a href="{{ route('pemilik.lapangan.create') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-sport-600 hover:bg-sport-700 text-white font-bold text-xs shadow-md shadow-sport-600/30 transition">
                <i class="fa-solid fa-plus mr-1.5"></i> Tambah Lapangan Baru
            </a>
        </div>

        @if($lapangans->isEmpty())
            <div class="text-center py-16 bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fa-solid fa-futbol"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800">Anda belum mendaftarkan lapangan</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    Mulai tambahkan lapangan futsal, badminton, basket, atau voli Anda ke sistem Sportify.
                </p>
                <a href="{{ route('pemilik.lapangan.create') }}" class="mt-4 inline-block px-5 py-2.5 rounded-xl bg-sport-600 text-white text-xs font-bold hover:bg-sport-700 transition">
                    Tambah Lapangan Sekarang
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($lapangans as $lap)
                    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-lg transition">
                        <div>
                            <div class="relative h-48 w-full bg-slate-900">
                                <img src="{{ $lap->foto ?: 'https://images.unsplash.com/photo-1529900748604-07564a03e7a6?w=800&auto=format&fit=crop&q=80' }}" class="w-full h-full object-cover">
                                <div class="absolute top-3 left-3">
                                    <span class="px-2.5 py-1 rounded-xl text-xs font-bold bg-dark-900/80 backdrop-blur-md text-white">
                                        {{ $lap->jenis_olahraga }}
                                    </span>
                                </div>
                                <div class="absolute bottom-3 right-3">
                                    <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-sport-600 text-white shadow-md">
                                        {{ \App\Helpers\Sportify::rupiah($lap->harga_per_jam) }}/jam
                                    </span>
                                </div>
                            </div>

                            <div class="p-6 space-y-3">
                                <h3 class="font-display font-bold text-lg text-slate-900 leading-snug">
                                    {{ $lap->nama_lapangan }}
                                </h3>

                                <p class="text-xs text-slate-500 flex items-start">
                                    <i class="fa-solid fa-location-dot text-rose-500 mr-2 mt-0.5 flex-shrink-0"></i>
                                    <span class="line-clamp-2">{{ $lap->lokasi }}</span>
                                </p>

                                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600">
                                    <span><i class="fa-solid fa-clock text-slate-400 mr-1"></i> {{ $lap->slots_count }} Slot Tersedia</span>
                                    <span class="font-bold text-emerald-600"><i class="fa-solid fa-check-circle mr-1"></i> Disetujui</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 pt-0 flex items-center justify-between gap-2 border-t border-slate-100 mt-2">
                            <a href="{{ route('pemilik.slots', ['id_lapangan' => $lap->id_lapangan]) }}" class="flex-1 py-2 text-center rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                                <i class="fa-solid fa-clock mr-1"></i> Atur Slot
                            </a>
                            <a href="{{ route('pemilik.lapangan.edit', $lap->id_lapangan) }}" class="py-2 px-3 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs transition">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('pemilik.lapangan.destroy', $lap->id_lapangan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lapangan ini beserta seluruh slot jadwalnya?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="py-2 px-3 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs transition">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
