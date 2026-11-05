@extends('sportify.layouts.app')

@section('title', 'Dashboard Pemilik Lapangan - Sportify')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700">PORTAL MITRA VENUE</span>
                    <span class="text-xs text-slate-400">|</span>
                    <span class="text-xs text-slate-500">{{ session('sportify_user_email') }}</span>
                </div>
                <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight mt-1">
                    Dashboard {{ session('sportify_user_name') }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Pantau kinerja penyewaan lapangan, konfirmasi jadwal, dan verifikasi bukti pembayaran.
                </p>
            </div>

            <div class="flex items-center space-x-2">
                <a href="{{ route('pemilik.lapangan.create') }}" class="px-4 py-2.5 rounded-xl bg-sport-600 hover:bg-sport-700 text-white font-bold text-xs shadow-md shadow-sport-600/30 transition">
                    <i class="fa-solid fa-plus mr-1.5"></i> Tambah Lapangan
                </a>
                <a href="{{ route('pemilik.slots') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs shadow-md transition">
                    <i class="fa-solid fa-clock mr-1.5"></i> Atur Slot
                </a>
            </div>
        </div>

        <!-- Metric Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            
            <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Lapangan</span>
                    <span class="font-display font-extrabold text-3xl text-slate-900 mt-1 block">{{ $totalLapangan }}</span>
                    <span class="text-[11px] text-slate-500">Aktif disewakan</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-sport-50 text-sport-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-futbol"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Pesanan Masuk</span>
                    <span class="font-display font-extrabold text-3xl text-slate-900 mt-1 block">{{ $totalBooking }}</span>
                    <span class="text-[11px] text-slate-500">{{ $confirmedBooking }} Terkonfirmasi</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm flex items-center justify-between {{ $pendingBooking > 0 ? 'ring-2 ring-amber-400' : '' }}">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Perlu Verifikasi</span>
                    <span class="font-display font-extrabold text-3xl {{ $pendingBooking > 0 ? 'text-amber-500' : 'text-slate-900' }} mt-1 block">
                        {{ $pendingBooking }}
                    </span>
                    <span class="text-[11px] text-slate-500">Menunggu cek bukti bayar</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Pendapatan</span>
                    <span class="font-display font-extrabold text-xl text-emerald-600 mt-1 block">
                        {{ \App\Helpers\Sportify::rupiah($totalPendapatan) }}
                    </span>
                    <span class="text-[11px] text-slate-500">Dari transaksi lunas</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-wallet"></i>
                </div>
            </div>

        </div>

        <!-- Quick Alert for Pending Bookings -->
        @if($pendingBooking > 0)
            <div class="p-4 rounded-2xl bg-gradient-to-r from-amber-500/10 via-amber-500/5 to-transparent border border-amber-300 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold">
                        <i class="fa-solid fa-bell animate-bounce"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-amber-900">Ada {{ $pendingBooking }} pesanan baru menunggu konfirmasi pembayaran!</h4>
                        <p class="text-[11px] text-amber-700">Periksa bukti transfer pelanggan agar status pesanan terkonfirmasi dan slot terkunci resmi.</p>
                    </div>
                </div>
                <a href="{{ route('pemilik.bookings', ['status' => 'pending']) }}" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-xs transition shadow-sm">
                    Periksa Sekarang <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        @endif

        <!-- Recent Bookings Table -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden" x-data="{ proofModal: false, proofUrl: '' }">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="font-display font-bold text-lg text-slate-900">Pesanan Masuk Terbaru</h3>
                    <p class="text-xs text-slate-500">Daftar booking pada lapangan milik Anda</p>
                </div>
                <a href="{{ route('pemilik.bookings') }}" class="text-xs font-bold text-sport-600 hover:text-sport-700">
                    Lihat Semua Pesanan <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>

            @if($recentBookings->isEmpty())
                <div class="p-12 text-center text-slate-400 text-xs">
                    <i class="fa-solid fa-calendar-xmark text-3xl mb-2 text-slate-300"></i>
                    <p class="font-bold text-slate-600">Belum ada pesanan yang masuk.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px] border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-3 font-bold">Kode / Pelanggan</th>
                                <th class="px-6 py-3 font-bold">Lapangan</th>
                                <th class="px-6 py-3 font-bold">Jadwal Main</th>
                                <th class="px-6 py-3 font-bold">Total Biaya</th>
                                <th class="px-6 py-3 font-bold">Status</th>
                                <th class="px-6 py-3 font-bold">Bukti Bayar</th>
                                <th class="px-6 py-3 font-bold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentBookings as $b)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-6 py-4">
                                        <span class="font-mono font-bold text-slate-900 block">#SPT-{{ str_pad($b->id_booking, 5, '0', STR_PAD_LEFT) }}</span>
                                        <span class="text-slate-500">{{ $b->customer->nama ?? 'Pelanggan' }}</span>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-800">
                                        {{ $b->slot->lapangan->nama_lapangan }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="block text-slate-800 font-bold">{{ \Carbon\Carbon::parse($b->slot->tanggal)->format('d M Y') }}</span>
                                        <span class="text-[11px] text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded">
                                            {{ substr($b->slot->jam_mulai, 0, 5) }} - {{ substr($b->slot->jam_selesai, 0, 5) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-slate-900">
                                        {{ \App\Helpers\Sportify::rupiah($b->total_harga) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($b->status_booking === 'pending')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800">
                                                Pending
                                            </span>
                                        @elseif($b->status_booking === 'confirmed')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-blue-100 text-blue-800">
                                                Confirmed
                                            </span>
                                        @elseif($b->status_booking === 'completed')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800">
                                                Completed
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800">
                                                Cancelled
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($b->pembayaran && $b->pembayaran->bukti_bayar)
                                            <button type="button" @click="proofUrl = '{{ $b->pembayaran->bukti_bayar }}'; proofModal = true" class="text-sport-600 font-bold hover:underline flex items-center">
                                                <i class="fa-solid fa-image mr-1"></i> Lihat Foto
                                            </button>
                                        @else
                                            <span class="text-slate-400 italic">Belum diunggah</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if($b->status_booking === 'pending')
                                            <div class="flex items-center justify-end space-x-1.5">
                                                <form action="{{ route('pemilik.booking.verify', $b->id_booking) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="action" value="approve">
                                                    <button type="submit" title="Setujui Pembayaran" class="px-2.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition">
                                                        <i class="fa-solid fa-check mr-1"></i> Terima
                                                    </button>
                                                </form>

                                                <form action="{{ route('pemilik.booking.verify', $b->id_booking) }}" method="POST" onsubmit="return confirm('Tolak pembayaran ini?');">
                                                    @csrf
                                                    <input type="hidden" name="action" value="reject">
                                                    <button type="submit" title="Tolak Pembayaran" class="px-2.5 py-1.5 rounded-lg bg-rose-100 hover:bg-rose-200 text-rose-700 font-bold text-xs transition">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($b->status_booking === 'confirmed')
                                            <form action="{{ route('pemilik.booking.complete', $b->id_booking) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs transition">
                                                    <i class="fa-solid fa-flag-checkered mr-1"></i> Tandai Selesai
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Modal Proof of Payment View -->
            <div x-show="proofModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen px-4 text-center">
                    <div @click="proofModal = false" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm"></div>
                    <div class="inline-block bg-white rounded-3xl p-6 text-left overflow-hidden shadow-2xl transform transition-all max-w-lg w-full relative z-10 border border-slate-100">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-bold text-slate-900 text-sm">Bukti Transfer Pelanggan</h4>
                            <button @click="proofModal = false" class="text-slate-400 hover:text-slate-700">
                                <i class="fa-solid fa-xmark text-lg"></i>
                            </button>
                        </div>
                        <img :src="proofUrl" class="w-full max-h-96 object-contain rounded-2xl border border-slate-200">
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
