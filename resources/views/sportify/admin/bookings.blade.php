@extends('sportify.layouts.app')

@section('title', 'Monitoring Semua Pesanan - Admin Sportify')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition mb-1 inline-block">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Dashboard Admin
                </a>
                <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                    Monitoring Seluruh Pesanan Platform
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Pengawasan komprehensif seluruh aktivitas penyewaan lapangan di Sportify.
                </p>
            </div>
        </div>

        <!-- Filter Status Pills -->
        <div class="flex flex-wrap items-center gap-2">
            <span class="text-xs font-bold text-slate-500 mr-1">Filter:</span>
            <a href="{{ route('admin.bookings') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ !request('status') || request('status') === 'all' ? 'bg-slate-900 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Semua
            </a>
            <a href="{{ route('admin.bookings', ['status' => 'pending']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === 'pending' ? 'bg-amber-500 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Pending
            </a>
            <a href="{{ route('admin.bookings', ['status' => 'confirmed']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === 'confirmed' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Confirmed
            </a>
            <a href="{{ route('admin.bookings', ['status' => 'completed']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === 'completed' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Completed
            </a>
            <a href="{{ route('admin.bookings', ['status' => 'cancelled']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === 'cancelled' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Cancelled
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px] border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3.5 font-bold">Kode</th>
                            <th class="px-6 py-3.5 font-bold">Pelanggan</th>
                            <th class="px-6 py-3.5 font-bold">Lapangan & Mitra</th>
                            <th class="px-6 py-3.5 font-bold">Jadwal Main</th>
                            <th class="px-6 py-3.5 font-bold">Biaya & Pembayaran</th>
                            <th class="px-6 py-3.5 font-bold">Status</th>
                            <th class="px-6 py-3.5 font-bold text-right">Invoice</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($bookings as $b)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-6 py-4 font-mono font-bold text-slate-900">
                                    #SPT-{{ str_pad($b->id_booking, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-slate-800 block">{{ $b->customer->nama ?? 'Pelanggan' }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $b->customer->email }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-slate-800 block">{{ $b->slot->lapangan->nama_lapangan }}</span>
                                    <span class="text-[10px] text-slate-500">Mitra: {{ $b->slot->lapangan->pemilik->nama_pemilik }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-slate-800 font-bold block">{{ \Carbon\Carbon::parse($b->slot->tanggal)->format('d M Y') }}</span>
                                    <span class="text-[10px] text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded">
                                        {{ substr($b->slot->jam_mulai, 0, 5) }} - {{ substr($b->slot->jam_selesai, 0, 5) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-extrabold text-slate-900 block text-xs">
                                        {{ \App\Helpers\Sportify::rupiah($b->total_harga) }}
                                    </span>
                                    <span class="text-[10px] text-slate-500">
                                        {{ $b->pembayaran->metode_bayar ?? 'Belum memilih' }} 
                                        ({{ $b->pembayaran->status_bayar ?? 'unpaid' }})
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($b->status_booking === 'pending')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800">Pending</span>
                                    @elseif($b->status_booking === 'confirmed')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-100 text-blue-800">Confirmed</span>
                                    @elseif($b->status_booking === 'completed')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800">Completed</span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800">Cancelled</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('booking.invoice', $b->id_booking) }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs inline-flex items-center">
                                        <i class="fa-solid fa-receipt mr-1"></i> Cetak
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $bookings->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
