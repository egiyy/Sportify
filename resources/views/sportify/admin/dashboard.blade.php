@extends('sportify.layouts.app')

@section('title', 'Admin Dashboard - Sportify')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-700">PANEL ADMINISTRATOR SISTEM</span>
                    <span class="text-xs text-slate-400">|</span>
                    <span class="text-xs text-slate-500">{{ session('sportify_user_email') }}</span>
                </div>
                <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight mt-1">
                    Pusat Kontrol & Pengawasan Sportify
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Memantau data lapangan, transaksi pemesanan, verifikasi mitra, dan katalog reward.
                </p>
            </div>

            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.lapangan') }}" class="px-4 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs shadow-md shadow-purple-600/30 transition">
                    <i class="fa-solid fa-check-to-slot mr-1.5"></i> Verifikasi Lapangan
                </a>
                <a href="{{ route('admin.rewards') }}" class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-xs shadow-md transition">
                    <i class="fa-solid fa-gifts mr-1.5"></i> Kelola Hadiah
                </a>
            </div>
        </div>

        <!-- 7 Key System Metrics Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4">
            
            <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Customer</span>
                <span class="font-display font-extrabold text-2xl text-slate-900 mt-1 block">{{ $stats['total_customer'] }}</span>
                <span class="text-[10px] text-slate-500">Akun terdaftar</span>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Mitra Pemilik</span>
                <span class="font-display font-extrabold text-2xl text-slate-900 mt-1 block">{{ $stats['total_pemilik'] }}</span>
                <span class="text-[10px] text-slate-500">Pengelola venue</span>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Lapangan</span>
                <span class="font-display font-extrabold text-2xl text-slate-900 mt-1 block">{{ $stats['total_lapangan'] }}</span>
                <span class="text-[10px] text-slate-500">Venue di sistem</span>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Transaksi Booking</span>
                <span class="font-display font-extrabold text-2xl text-slate-900 mt-1 block">{{ $stats['total_booking'] }}</span>
                <span class="text-[10px] text-slate-500">Pesanan masuk</span>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Omset Berhasil (Lunas)</span>
                <span class="font-display font-extrabold text-lg text-emerald-600 mt-1 block">
                    {{ \App\Helpers\Sportify::rupiah($stats['total_omset']) }}
                </span>
                <span class="text-[10px] text-slate-500">Semua venue</span>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Poin Loyalitas Beredar</span>
                <span class="font-display font-extrabold text-2xl text-amber-500 mt-1 block">{{ $stats['total_poin_beredar'] }}</span>
                <span class="text-[10px] text-slate-500">Dimiliki pelanggan</span>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Klaim Hadiah Reward</span>
                <span class="font-display font-extrabold text-2xl text-purple-600 mt-1 block">{{ $stats['total_penukaran'] }}</span>
                <span class="text-[10px] text-slate-500">Penukaran selesai</span>
            </div>

            <div class="bg-gradient-to-br from-slate-900 to-dark-950 text-white p-5 rounded-3xl shadow-sm flex flex-col justify-between">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status Database</span>
                <div class="flex items-center space-x-2 my-1">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="font-bold text-xs text-white">PostgreSQL Connected</span>
                </div>
                <span class="text-[10px] text-slate-400">Database: sportify</span>
            </div>

        </div>

        <!-- Pending Field Approvals (Per Bab II 2.3: Admin memverifikasi venue baru) -->
        @if($pendingLapangan->isNotEmpty())
            <div class="bg-amber-50 border border-amber-300 rounded-3xl p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold">
                            <i class="fa-solid fa-clock text-lg"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm text-amber-900">Ada {{ $pendingLapangan->count() }} Lapangan Menunggu Persetujuan Admin</h3>
                            <p class="text-xs text-amber-700">Lapangan hanya akan tampil ke pelanggan setelah disetujui admin.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($pendingLapangan as $pl)
                        <div class="bg-white p-4 rounded-2xl border border-amber-200 flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-xs text-slate-900">{{ $pl->nama_lapangan }} ({{ $pl->jenis_olahraga }})</h4>
                                <span class="text-[11px] text-slate-500">Pemilik: {{ $pl->pemilik->nama_pemilik }} &bull; {{ \App\Helpers\Sportify::rupiah($pl->harga_per_jam) }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <form action="{{ route('admin.lapangan.verify', $pl->id_lapangan) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-700">
                                        Setujui
                                    </button>
                                </form>
                                <form action="{{ route('admin.lapangan.verify', $pl->id_lapangan) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-100 text-rose-700 font-bold text-xs hover:bg-rose-200">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Recent System Activity Table -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="font-display font-bold text-lg text-slate-900">Monitoring Pemesanan Terkini</h3>
                    <p class="text-xs text-slate-500">Transparansi seluruh pemesanan yang berlangsung di sistem Sportify</p>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.bookings') }}" class="text-xs font-bold text-purple-600 hover:text-purple-700">
                        Semua Booking <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px] border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3 font-bold">Kode</th>
                            <th class="px-6 py-3 font-bold">Pelanggan</th>
                            <th class="px-6 py-3 font-bold">Lapangan & Mitra</th>
                            <th class="px-6 py-3 font-bold">Jadwal Main</th>
                            <th class="px-6 py-3 font-bold">Total Biaya</th>
                            <th class="px-6 py-3 font-bold">Status Pesanan</th>
                            <th class="px-6 py-3 font-bold text-right">Invoice</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentBookings as $b)
                            <tr class="hover:bg-slate-50/70">
                                <td class="px-6 py-3.5 font-mono font-bold text-slate-900">
                                    #SPT-{{ str_pad($b->id_booking, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-3.5">
                                    <span class="font-bold text-slate-800 block">{{ $b->customer->nama ?? 'Pelanggan' }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $b->customer->email }}</span>
                                </td>
                                <td class="px-6 py-3.5">
                                    <span class="font-bold text-slate-800 block">{{ $b->slot->lapangan->nama_lapangan }}</span>
                                    <span class="text-[10px] text-slate-500">{{ $b->slot->lapangan->pemilik->nama_pemilik }}</span>
                                </td>
                                <td class="px-6 py-3.5">
                                    <span class="text-slate-800 font-bold block">{{ \Carbon\Carbon::parse($b->slot->tanggal)->format('d M Y') }}</span>
                                    <span class="text-[10px] text-emerald-700">{{ substr($b->slot->jam_mulai, 0, 5) }} - {{ substr($b->slot->jam_selesai, 0, 5) }}</span>
                                </td>
                                <td class="px-6 py-3.5 font-bold text-slate-900">
                                    {{ \App\Helpers\Sportify::rupiah($b->total_harga) }}
                                </td>
                                <td class="px-6 py-3.5">
                                    @if($b->status_booking === 'pending')
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">Pending</span>
                                    @elseif($b->status_booking === 'confirmed')
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800">Confirmed</span>
                                    @elseif($b->status_booking === 'completed')
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">Completed</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-800">Cancelled</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3.5 text-right">
                                    <a href="{{ route('booking.invoice', $b->id_booking) }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[10px]">
                                        <i class="fa-solid fa-print mr-1"></i> Cetak
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
