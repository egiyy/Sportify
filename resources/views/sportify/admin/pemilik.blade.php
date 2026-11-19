@extends('sportify.layouts.app')

@section('title', 'Verifikasi Akun Pemilik - Admin Sportify')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition mb-1 inline-block">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Dashboard Admin
                </a>
                <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                    Verifikasi Akun Pemilik Lapangan
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Kelola dan verifikasi akun mitra pemilik lapangan yang mendaftar ke sistem.
                </p>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 uppercase tracking-wider font-bold">
                        <tr>
                            <th class="py-4 px-6">ID & Nama Pemilik</th>
                            <th class="py-4 px-6">Kontak & Email</th>
                            <th class="py-4 px-6">Jumlah Lapangan</th>
                            <th class="py-4 px-6">Status Verifikasi</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pemiliks as $pemilik)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-xs">
                                            {{ strtoupper(substr($pemilik->nama_pemilik, 0, 1)) }}
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-900 block text-sm">{{ $pemilik->nama_pemilik }}</span>
                                            <span class="text-[10px] text-slate-400 font-mono">ID: #OWN-{{ str_pad($pemilik->id_pemilik, 4, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-slate-800 block font-medium">{{ $pemilik->email }}</span>
                                    <span class="text-[11px] text-slate-500 font-mono">{{ $pemilik->no_wa ?? '-' }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                        {{ $pemilik->lapangan_count }} Lapangan
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    @if($pemilik->status_verifikasi === 'approved')
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-emerald-100 text-emerald-800">
                                            <i class="fa-solid fa-circle-check mr-1"></i> Aktif (Disetujui)
                                        </span>
                                    @elseif($pemilik->status_verifikasi === 'rejected')
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-rose-100 text-rose-800">
                                            <i class="fa-solid fa-circle-xmark mr-1"></i> Ditolak
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-amber-100 text-amber-800 animate-pulse">
                                            <i class="fa-solid fa-clock mr-1"></i> Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        @if($pemilik->status_verifikasi !== 'approved')
                                            <form action="{{ route('admin.pemilik.verify', $pemilik->id_pemilik) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition shadow-sm">
                                                    Setujui
                                                </button>
                                            </form>
                                        @endif
                                        @if($pemilik->status_verifikasi !== 'rejected')
                                            <form action="{{ route('admin.pemilik.verify', $pemilik->id_pemilik) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menonaktifkan/menolak akun pemilik ini?');">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs transition">
                                                    Tolak
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">
                                    Belum ada data pemilik lapangan terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pemiliks->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $pemiliks->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
