@extends('sportify.layouts.app')

@section('title', 'Monitoring Seluruh Pembayaran - Admin Sportify')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen" x-data="{ proofModal: false, proofUrl: '', proofCustomer: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition mb-1 inline-block">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Dashboard Admin
                </a>
                <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                    Monitoring Seluruh Pembayaran Platform
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Rekapitulasi bukti transfer bank, QRIS, dan status pelunasan booking lapangan.
                </p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px] border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3.5 font-bold">ID Bayar</th>
                            <th class="px-6 py-3.5 font-bold">Kode Booking / Pelanggan</th>
                            <th class="px-6 py-3.5 font-bold">Lapangan</th>
                            <th class="px-6 py-3.5 font-bold">Metode Bayar</th>
                            <th class="px-6 py-3.5 font-bold">Waktu Transaksi</th>
                            <th class="px-6 py-3.5 font-bold">Status Bayar</th>
                            <th class="px-6 py-3.5 font-bold">Bukti Transfer</th>
                            <th class="px-6 py-3.5 font-bold text-right">Invoice</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($pembayarans as $p)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-6 py-4 font-mono font-bold text-slate-900">
                                    #PAY-{{ str_pad($p->id_pembayaran, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-mono font-bold text-slate-800 block text-xs">
                                        #SPT-{{ str_pad($p->booking->id_booking, 5, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <span class="text-slate-600">{{ $p->booking->customer->nama ?? 'Pelanggan' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-slate-800 block">{{ $p->booking->slot->lapangan->nama_lapangan }}</span>
                                    <span class="text-[10px] text-slate-500">{{ \App\Helpers\Sportify::rupiah($p->booking->total_harga) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-0.5 rounded font-bold text-[10px] bg-slate-100 text-slate-800">
                                        {{ $p->metode_bayar }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $p->waktu_transaksi->translatedFormat('d M Y, H:i') }} WIB
                                </td>
                                <td class="px-6 py-4">
                                    @if($p->status_bayar === 'lunas')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800">
                                            Lunas
                                        </span>
                                    @elseif($p->status_bayar === 'pending')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800">
                                            Pending
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800">
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($p->bukti_bayar)
                                        <button type="button" @click="proofUrl = '{{ $p->bukti_bayar }}'; proofCustomer = '{{ $p->booking->customer->nama }}'; proofModal = true" class="text-purple-600 hover:text-purple-800 font-bold flex items-center">
                                            <i class="fa-solid fa-image mr-1"></i> Buka Foto
                                        </button>
                                    @else
                                        <span class="text-slate-400 italic">Belum ada</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('booking.invoice', $p->id_booking) }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[10px]">
                                        <i class="fa-solid fa-receipt mr-1"></i> Invoice
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $pembayarans->links() }}
            </div>
        </div>

    </div>

    <!-- Modal Proof Viewer -->
    <div x-show="proofModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 text-center">
            <div @click="proofModal = false" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm"></div>
            <div class="inline-block bg-white rounded-3xl p-6 text-left overflow-hidden shadow-2xl transform transition-all max-w-lg w-full relative z-10 border border-slate-100">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                    <h4 class="font-bold text-slate-900 text-sm">Bukti Pembayaran (<span x-text="proofCustomer"></span>)</h4>
                    <button @click="proofModal = false" class="text-slate-400 hover:text-slate-700">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
                <img :src="proofUrl" class="w-full max-h-[70vh] object-contain rounded-2xl border border-slate-200">
            </div>
        </div>
    </div>

</div>
@endsection
