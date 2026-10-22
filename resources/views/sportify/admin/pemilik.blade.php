@extends('sportify.layouts.app')

@section('title', 'Verifikasi Akun Pemilik Lapangan - Admin Sportify')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition mb-1 inline-block">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Dashboard Admin
                </a>
                <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                    Verifikasi Akun Pemilik Lapangan
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Memastikan legalitas pengelola venue sebelum lapangan mereka dapat disewakan secara publik.
                </p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px] border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3.5 font-bold">Nama Pemilik / Usaha</th>
                            <th class="px-6 py-3.5 font-bold">Email</th>
                            <th class="px-6 py-3.5 font-bold">No WhatsApp</th>
                            <th class="px-6 py-3.5 font-bold text-center">Jumlah Lapangan</th>
                            <th class="px-6 py-3.5 font-bold">Status Verifikasi</th>
                            <th class="px-6 py-3.5 font-bold text-right">Tindakan Admin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($pemiliks as $p)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-slate-900 block text-xs">{{ $p->nama_pemilik }}</span>
                                    <span class="text-[10px] text-slate-400">ID Pemilik: #{{ $p->id_pemilik }}</span>
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $p->email }}
                                </td>
                                <td class="px-6 py-4 font-mono text-slate-700">
                                    {{ $p->no_wa ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-slate-900">
                                    <span class="px-2.5 py-0.5 rounded-lg bg-slate-100 text-slate-800">
                                        {{ $p->lapangan_count }} Lapangan
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($p->status_verifikasi === 'approved')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800">
                                            <i class="fa-solid fa-check mr-1"></i> Terverifikasi Aktif
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800">
                                            <i class="fa-solid fa-ban mr-1"></i> Ditolak / Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        @if($p->status_verifikasi !== 'approved')
                                            <form action="{{ route('admin.pemilik.verify', $p->id_pemilik) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-700">
                                                    Aktifkan Akun
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.pemilik.verify', $p->id_pemilik) }}" method="POST" onsubmit="return confirm('Nonaktifkan akun pemilik ini?');">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-50 text-rose-700 font-bold text-xs hover:bg-rose-100 border border-rose-200">
                                                    Nonaktifkan
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
                {{ $pemiliks->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
