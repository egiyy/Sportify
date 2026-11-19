@extends('sportify.layouts.app')

@section('title', 'Monitoring Seluruh Pesanan - Admin Sportify')

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
                    Monitoring Seluruh Pemesanan
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Pantau seluruh riwayat transaksi pemesanan lapangan olahraga di seluruh mitra.
                </p>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.bookings', ['status' => 'all']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition {{ !$status || $status === 'all' ? 'bg-slate-900 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Semua Pesanan
            </a>
            <a href="{{ route('admin.bookings', ['status' => 'pending']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'pending' ? 'bg-amber-500 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Menunggu Pembayaran
            </a>
            <a href="{{ route('admin.bookings', ['status' => 'confirmed']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'confirmed' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Terkonfirmasi
            </a>
            <a href="{{ route('admin.bookings', ['status' => 'completed']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'completed' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Selesai
            </a>
            <a href="{{ route('admin.bookings', ['status' => 'cancelled']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'cancelled' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Dibatalkan
            </a>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 uppercase tracking-wider font-bold">
                        <tr>
                            <th class="py-4 px-6">ID Booking</th>
                            <th class="py-4 px-6">Pelanggan</th>
                            <th class="py-4 px-6">Lapangan & Mitra</th>
                            <th class="py-4 px-6">Jadwal Main</th>
                            <th class="py-4 px-6">Total Biaya</th>
                            <th class="py-4 px-6">Status Booking</th>
                            <th class="py-4 px-6 text-right">Invoice</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($bookings as $b)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-4 px-6 font-mono font-bold text-slate-900">
                                    #SPT-{{ str_pad($b->id_booking, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="py-4 px-6">
                                    <span class="font-bold text-slate-900 block">{{ $b->customer->nama ?? 'Customer' }}</span>
                                    <span class="text-[11px] text-slate-500">{{ $b->customer->email ?? '-' }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="font-semibold text-slate-900 block">{{ $b->slot->lapangan->nama_lapangan ?? 'Lapangan' }}</span>
                                    <span class="text-[11px] text-slate-500">{{ $b->slot->lapangan->pemilik->nama_pemilik ?? '-' }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-slate-800 block font-medium">{{ \Carbon\Carbon::parse($b->slot->tanggal)->translatedFormat('d M Y') }}</span>
                                    <span class="text-[11px] text-emerald-600 font-semibold">
                                        {{ substr($b->slot->jam_mulai, 0, 5) }} - {{ substr($b->slot->jam_selesai, 0, 5) }} WIB
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-bold text-slate-900">
                                    {{ \App\Helpers\Sportify::rupiah($b->total_harga) }}
                                </td>
                                <td class="py-4 px-6">
                                    @if($b->status_booking === 'pending')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800">
                                            Menunggu
                                        </span>
                                    @elseif($b->status_booking === 'confirmed')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-blue-100 text-blue-800">
                                            Terkonfirmasi
                                        </span>
                                    @elseif($b->status_booking === 'completed')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800">
                                            Dibatalkan
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <a href="{{ route('booking.invoice', $b->id_booking) }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                                        <i class="fa-solid fa-receipt mr-1"></i> Invoice
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400">
                                    Tidak ada data pemesanan ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($bookings->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
