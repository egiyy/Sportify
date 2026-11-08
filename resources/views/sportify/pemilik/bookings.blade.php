@extends('sportify.layouts.app')

@section('title', 'Verifikasi & Kelola Pesanan - Pemilik Lapangan')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen" x-data="{ proofModal: false, proofUrl: '', proofCustomer: '', proofTotal: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('pemilik.dashboard') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition mb-1 inline-block">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Dashboard Pemilik
                </a>
                <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                    Verifikasi Pembayaran & Pesanan Masuk
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Periksa struk transfer pelanggan, konfirmasi jadwal bermain, atau tandai pesanan telah selesai.
                </p>
            </div>
        </div>

        <!-- Filter Pills -->
        <div class="flex flex-wrap items-center gap-2">
            <span class="text-xs font-bold text-slate-500 mr-1">Filter Status:</span>
            <a href="{{ route('pemilik.bookings') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ !request('status') || request('status') === 'all' ? 'bg-slate-900 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Semua Pesanan
            </a>
            <a href="{{ route('pemilik.bookings', ['status' => 'pending']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === 'pending' ? 'bg-amber-500 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Menunggu Verifikasi (Pending)
            </a>
            <a href="{{ route('pemilik.bookings', ['status' => 'confirmed']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === 'confirmed' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Terkonfirmasi (Confirmed)
            </a>
            <a href="{{ route('pemilik.bookings', ['status' => 'completed']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === 'completed' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Selesai Bermain
            </a>
            <a href="{{ route('pemilik.bookings', ['status' => 'cancelled']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === 'cancelled' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Dibatalkan / Ditolak
            </a>
        </div>

        <!-- Bookings Table -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
            @if($bookings->isEmpty())
                <div class="p-16 text-center text-slate-400 text-xs">
                    <i class="fa-solid fa-file-circle-xmark text-4xl text-slate-300 mb-3"></i>
                    <h3 class="font-bold text-sm text-slate-800">Tidak ada pesanan ditemukan</h3>
                    <p class="text-[11px] text-slate-500 mt-1">Tidak ada catatan booking dengan filter status ini.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px] border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-3.5 font-bold">Kode / Pelanggan</th>
                                <th class="px-6 py-3.5 font-bold">Lapangan</th>
                                <th class="px-6 py-3.5 font-bold">Jadwal Main</th>
                                <th class="px-6 py-3.5 font-bold">Biaya & Metode</th>
                                <th class="px-6 py-3.5 font-bold">Bukti Transfer</th>
                                <th class="px-6 py-3.5 font-bold">Status Pesanan</th>
                                <th class="px-6 py-3.5 font-bold text-right">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($bookings as $b)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-6 py-4">
                                        <span class="font-mono font-bold text-slate-900 block text-xs">#SPT-{{ str_pad($b->id_booking, 5, '0', STR_PAD_LEFT) }}</span>
                                        <span class="font-bold text-slate-800">{{ $b->customer->nama ?? 'Pelanggan' }}</span>
                                        <span class="block text-[10px] text-slate-400">{{ $b->customer->no_wa ?? $b->customer->email }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-slate-800 block">{{ $b->slot->lapangan->nama_lapangan }}</span>
                                        <span class="text-[10px] text-slate-500">{{ $b->slot->lapangan->jenis_olahraga }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="block text-slate-800 font-bold">{{ \Carbon\Carbon::parse($b->slot->tanggal)->format('d M Y') }}</span>
                                        <span class="text-[11px] text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded font-semibold inline-block mt-0.5">
                                            {{ substr($b->slot->jam_mulai, 0, 5) }} - {{ substr($b->slot->jam_selesai, 0, 5) }} WIB
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-extrabold text-slate-900 block text-xs">
                                            {{ \App\Helpers\Sportify::rupiah($b->total_harga) }}
                                        </span>
                                        <span class="text-[10px] text-slate-500">
                                            {{ $b->pembayaran->metode_bayar ?? 'Belum memilih' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($b->pembayaran && $b->pembayaran->bukti_bayar)
                                            <button type="button" @click="proofUrl = '{{ $b->pembayaran->bukti_bayar }}'; proofCustomer = '{{ $b->customer->nama }}'; proofTotal = '{{ \App\Helpers\Sportify::rupiah($b->total_harga) }}'; proofModal = true" 
                                                    class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 border border-blue-200 font-bold text-[11px] hover:bg-blue-100 transition">
                                                <i class="fa-solid fa-image mr-1"></i> Buka Foto Struk
                                            </button>
                                        @else
                                            <span class="text-slate-400 italic text-[11px]">Belum diunggah</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($b->status_booking === 'pending')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800">
                                                Menunggu Verifikasi
                                            </span>
                                        @elseif($b->status_booking === 'confirmed')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-blue-100 text-blue-800">
                                                Terkonfirmasi (Lunas)
                                            </span>
                                        @elseif($b->status_booking === 'completed')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800">
                                                Selesai Main
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800">
                                                Dibatalkan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            @if($b->status_booking === 'pending')
                                                <form action="{{ route('pemilik.booking.verify', $b->id_booking) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="action" value="approve">
                                                    <button type="submit" title="Setujui & Konfirmasi Pembayaran" 
                                                            class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition shadow-sm">
                                                        <i class="fa-solid fa-circle-check mr-1"></i> Terima
                                                    </button>
                                                </form>

                                                <form action="{{ route('pemilik.booking.verify', $b->id_booking) }}" method="POST" onsubmit="return confirm('Tolak pesanan & bukti pembayaran ini?');">
                                                    @csrf
                                                    <input type="hidden" name="action" value="reject">
                                                    <button type="submit" title="Tolak Pesanan" 
                                                            class="px-2.5 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs transition border border-rose-200">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </button>
                                                </form>
                                            @elseif($b->status_booking === 'confirmed')
                                                <form action="{{ route('pemilik.booking.complete', $b->id_booking) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs transition">
                                                        <i class="fa-solid fa-flag-checkered mr-1"></i> Tandai Selesai
                                                    </button>
                                                </form>
                                            @endif

                                            <a href="{{ route('booking.invoice', $b->id_booking) }}" target="_blank" class="p-1.5 text-slate-500 hover:text-slate-800" title="Lihat Invoice">
                                                <i class="fa-solid fa-receipt text-sm"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-slate-100">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>

    </div>

    <!-- Modal Proof Viewer -->
    <div x-show="proofModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 text-center">
            <div @click="proofModal = false" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm"></div>
            <div class="inline-block bg-white rounded-3xl p-6 text-left overflow-hidden shadow-2xl transform transition-all max-w-lg w-full relative z-10 border border-slate-100">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">Bukti Pembayaran Pelanggan</h4>
                        <p class="text-[11px] text-slate-500" x-text="proofCustomer + ' - ' + proofTotal"></p>
                    </div>
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
