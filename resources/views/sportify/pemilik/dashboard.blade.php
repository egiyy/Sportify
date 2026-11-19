@extends('sportify.layouts.app')

@section('title', 'Dashboard Pemilik Lapangan - Sportify')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        @if(isset($pemilik) && $pemilik->status_verifikasi !== 'approved')
            <!-- ======================================================== -->
            <!-- TAMPILAN TUNGGAL: MENUNGGU VERIFIKASI AKUN DARI ADMIN    -->
            <!-- ======================================================== -->
            <div class="py-8 sm:py-16 max-w-2xl mx-auto text-center">
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xl p-8 sm:p-12 space-y-6">

                    <!-- Title & Status Badge -->
                    <div class="space-y-2">
                        <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                            Pendaftaran Akun Sedang Ditinjau
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto leading-relaxed">
                            Halo <strong class="text-slate-800">{{ $pemilik->nama_pemilik }}</strong>, akun pemilik venue Anda telah terdaftar dan saat ini sedang menunggu proses verifikasi dan persetujuan dari <strong>Administrator Sportify</strong>.
                        </p>
                    </div>

                    <!-- Info Box with Registration Details -->
                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200/80 text-left space-y-3">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rincian Akun Pemilik</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            <div>
                                <span class="text-slate-400 block text-[11px]">Nama Pemilik / Venue:</span>
                                <span class="font-bold text-slate-800">{{ $pemilik->nama_pemilik }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[11px]">Email Terdaftar:</span>
                                <span class="font-bold text-slate-800">{{ $pemilik->email }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[11px]">Nomor WhatsApp:</span>
                                <span class="font-bold text-slate-800">{{ $pemilik->no_wa ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[11px]">Waktu Pendaftaran:</span>
                                <span class="font-bold text-slate-800">{{ $pemilik->created_at ? $pemilik->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') : '-' }} WIB</span>
                            </div>
                        </div>
                    </div>

                    <!-- Notice message -->
                    <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200 text-blue-900 text-xs flex items-start space-x-3 text-left">
                        <i class="fa-solid fa-lock text-blue-600 text-base mt-0.5 flex-shrink-0"></i>
                        <div class="space-y-1">
                            <p class="font-bold text-blue-950">Akses Fitur Terkunci Sementara</p>
                            <p class="text-[11px] text-blue-800 leading-relaxed">
                                Silakan periksa berkala atau muat ulang halaman ini.
                            </p>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                        <button type="button" onclick="window.location.reload();" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-sport-600 hover:bg-sport-700 text-white font-bold text-xs shadow-md shadow-sport-600/30 transition flex items-center justify-center">
                            <i class="fa-solid fa-rotate mr-2"></i> Muat Ulang Status
                        </button>
                    </div>

                </div>
            </div>

        @else
            <!-- ======================================================== -->
            <!-- TAMPILAN DASHBOARD PENUH (AKUN PEMILIK SUDAH DISETUJUI)   -->
            <!-- ======================================================== -->

            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center space-x-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700">PORTAL MITRA VENUE</span>
                        <span class="text-xs text-slate-400">|</span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800">
                            <i class="fa-solid fa-circle-check mr-1"></i> Akun Terverifikasi
                        </span>
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

                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('pemilik.lapangan.create') }}" class="px-4 py-2.5 rounded-xl bg-sport-600 hover:bg-sport-700 text-white font-bold text-xs shadow-md shadow-sport-600/30 transition">
                        <i class="fa-solid fa-plus mr-1.5"></i> Tambah Lapangan
                    </a>
                    <a href="{{ route('pemilik.slots') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs shadow-md transition">
                        <i class="fa-solid fa-clock mr-1.5"></i> Atur Slot
                    </a>
                    <a href="{{ route('pemilik.ulasan.index') }}" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 font-bold text-xs shadow-sm transition">
                        <i class="fa-solid fa-comments mr-1.5 text-blue-500"></i> Ulasan
                    </a>
                </div>
            </div>

            @if(isset($pendingLapanganCount) && $pendingLapanganCount > 0)
                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs flex items-center justify-between shadow-sm">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-clock-rotate-left text-amber-600 text-xl"></i>
                        <div>
                            <span class="font-bold block text-sm">Ada {{ $pendingLapanganCount }} Lapangan Menunggu Persetujuan Admin</span>
                            <span class="text-amber-700">Lapangan baru akan tampil ke pelanggan setelah disetujui Administrator.</span>
                        </div>
                    </div>
                    <a href="{{ route('pemilik.lapangan.index') }}" class="px-3.5 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs transition">
                        Kelola Lapangan
                    </a>
                </div>
            @endif

            <!-- Metric Stat Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                
                <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Lapangan</span>
                        <span class="font-display font-extrabold text-3xl text-slate-900 mt-1 block">{{ $totalLapangan }}</span>
                        <span class="text-[11px] text-slate-500">{{ $approvedLapanganCount }} Disetujui Admin</span>
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

            <!-- Recent Bookings Table -->
            <div x-data="{ proofModal: false, proofUrl: '' }" class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
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
                    <div class="text-center py-12 text-slate-400">
                        <i class="fa-regular fa-calendar-xmark text-3xl mb-2 block"></i>
                        <span class="text-xs font-medium">Belum ada pesanan yang masuk.</span>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-600">
                            <thead class="bg-slate-50 text-slate-400 font-bold uppercase tracking-wider border-b border-slate-100 text-[10px]">
                                <tr>
                                    <th class="px-6 py-3.5">ID / Pelanggan</th>
                                    <th class="px-6 py-3.5">Lapangan</th>
                                    <th class="px-6 py-3.5">Jadwal Main</th>
                                    <th class="px-6 py-3.5">Total Tarif</th>
                                    <th class="px-6 py-3.5">Status Booking</th>
                                    <th class="px-6 py-3.5">Bukti Bayar</th>
                                    <th class="px-6 py-3.5 text-right">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium">
                                @foreach($recentBookings as $b)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="px-6 py-4">
                                            <span class="font-mono font-bold text-slate-900 block">#BK-{{ str_pad($b->id_booking, 5, '0', STR_PAD_LEFT) }}</span>
                                            <span class="text-[11px] text-slate-500">{{ $b->customer->nama ?? 'Customer' }} ({{ $b->customer->no_wa ?? '-' }})</span>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-slate-800">
                                            {{ $b->slot->lapangan->nama_lapangan ?? 'Lapangan' }}
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
        @endif

    </div>
</div>
@endsection
