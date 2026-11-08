@extends('sportify.layouts.app')

@section('title', 'Verifikasi & Monitoring Lapangan - Admin Sportify')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition mb-1 inline-block">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Dashboard Admin
                </a>
                <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                    Monitoring & Verifikasi Lapangan
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Memastikan keaslian venue dan kualitas fasilitas lapangan sebelum ditampilkan kepada pengguna.
                </p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px] border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3.5 font-bold">Foto</th>
                            <th class="px-6 py-3.5 font-bold">Nama Lapangan</th>
                            <th class="px-6 py-3.5 font-bold">Cabang Olahraga</th>
                            <th class="px-6 py-3.5 font-bold">Pemilik / Mitra</th>
                            <th class="px-6 py-3.5 font-bold">Tarif / Jam</th>
                            <th class="px-6 py-3.5 font-bold">Status Verifikasi</th>
                            <th class="px-6 py-3.5 font-bold text-right">Aksi Admin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($lapangans as $lap)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-6 py-3.5">
                                    <img src="{{ $lap->foto ?: 'https://images.unsplash.com/photo-1529900748604-07564a03e7a6?w=200' }}" class="w-12 h-10 object-cover rounded-xl border border-slate-200">
                                </td>
                                <td class="px-6 py-3.5">
                                    <span class="font-bold text-slate-900 block text-xs">{{ $lap->nama_lapangan }}</span>
                                    <span class="text-[10px] text-slate-400 line-clamp-1">{{ $lap->lokasi }}</span>
                                </td>
                                <td class="px-6 py-3.5">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-800">
                                        {{ $lap->jenis_olahraga }}
                                    </span>
                                </td>
                                <td class="px-6 py-3.5">
                                    <span class="font-semibold text-slate-800 block">{{ $lap->pemilik->nama_pemilik ?? 'Mitra Venue' }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $lap->pemilik->email ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-3.5 font-bold text-slate-900">
                                    {{ \App\Helpers\Sportify::rupiah($lap->harga_per_jam) }}
                                </td>
                                <td class="px-6 py-3.5">
                                    @if($lap->status_verifikasi === 'approved')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800">
                                            <i class="fa-solid fa-check mr-1"></i> Disetujui
                                        </span>
                                    @elseif($lap->status_verifikasi === 'pending')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800">
                                            <i class="fa-solid fa-clock mr-1"></i> Pending
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800">
                                            <i class="fa-solid fa-xmark mr-1"></i> Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-3.5 text-right">
                                    <div class="flex items-center justify-end space-x-1.5">
                                        @if($lap->status_verifikasi !== 'approved')
                                            <form action="{{ route('admin.lapangan.verify', $lap->id_lapangan) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="px-2.5 py-1 rounded-lg bg-emerald-600 text-white font-bold text-[10px] hover:bg-emerald-700">
                                                    Setujui
                                                </button>
                                            </form>
                                        @endif
                                        @if($lap->status_verifikasi !== 'rejected')
                                            <form action="{{ route('admin.lapangan.verify', $lap->id_lapangan) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-100 text-rose-700 font-bold text-[10px] hover:bg-rose-200">
                                                    Tolak
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $lapangans->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
