@extends('sportify.layouts.app')

@section('title', 'Monitoring Seluruh Pembayaran - Admin Sportify')

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
                    Monitoring Seluruh Pembayaran
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Pantau mutasi bukti bayar, status transaksi, dan keabsahan pembayaran pelanggan.
                </p>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 uppercase tracking-wider font-bold">
                        <tr>
                            <th class="py-4 px-6">ID Bayar & Booking</th>
                            <th class="py-4 px-6">Pelanggan</th>
                            <th class="py-4 px-6">Metode & Waktu Transaksi</th>
                            <th class="py-4 px-6">Nominal Biaya</th>
                            <th class="py-4 px-6">Bukti Transfer</th>
                            <th class="py-4 px-6">Status Bayar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pembayarans as $p)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-4 px-6">
                                    <span class="font-bold text-slate-900 block font-mono">#PAY-{{ str_pad($p->id_pembayaran, 4, '0', STR_PAD_LEFT) }}</span>
                                    <span class="text-[10px] text-slate-400 font-mono">Booking #SPT-{{ str_pad($p->booking->id_booking ?? 0, 5, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="font-bold text-slate-900 block">{{ $p->booking->customer->nama ?? 'Customer' }}</span>
                                    <span class="text-[11px] text-slate-500">{{ $p->booking->slot->lapangan->nama_lapangan ?? 'Lapangan' }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="font-bold text-slate-800 block">{{ $p->metode_bayar }}</span>
                                    <span class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($p->waktu_transaksi)->translatedFormat('d M Y, H:i') }}</span>
                                </td>
                                <td class="py-4 px-6 font-bold text-slate-900">
                                    {{ \App\Helpers\Sportify::rupiah($p->booking->total_harga ?? 0) }}
                                </td>
                                <td class="py-4 px-6">
                                    @if($p->bukti_bayar)
                                        <a href="{{ $p->bukti_bayar }}" target="_blank" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold text-[11px] transition">
                                            <i class="fa-solid fa-image mr-1"></i> Lihat Bukti
                                        </a>
                                    @else
                                        <span class="text-[11px] text-slate-400 italic">Belum diunggah</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @if($p->status_bayar === 'lunas')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800">
                                            <i class="fa-solid fa-check mr-1"></i> Lunas
                                        </span>
                                    @elseif($p->status_bayar === 'ditolak')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800">
                                            <i class="fa-solid fa-xmark mr-1"></i> Ditolak
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800">
                                            <i class="fa-solid fa-clock mr-1"></i> Pending
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400">
                                    Belum ada catatan transaksi pembayaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pembayarans->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $pembayarans->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
