
@extends('sportify.layouts.app')

@section('title', 'Monitoring Pembayaran - Admin Sportify')

@section('content')
<div class="min-h-screen bg-slate-50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Header -->
        <div>
            <a href="{{ route('admin.dashboard') }}"
                class="text-xs font-bold text-slate-400 hover:text-slate-600 mb-2 inline-block">
                <i class="fa-solid fa-arrow-left mr-1"></i>
                Dashboard Admin
            </a>

            <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900">
                Monitoring Pembayaran
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Pantau seluruh transaksi dan aktivitas pembayaran pelanggan Sportify.
            </p>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <p class="text-xs font-bold text-slate-400 uppercase">Total Transaksi</p>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-3">
                    {{ $totalTransaksi }}
                </h2>
                <p class="text-xs text-slate-400 mt-2">Seluruh pembayaran tercatat</p>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <p class="text-xs font-bold text-slate-400 uppercase">Menunggu Verifikasi</p>
                <h2 class="text-3xl font-extrabold text-amber-500 mt-3">
                    {{ $totalPending }}
                </h2>
                <p class="text-xs text-slate-400 mt-2">Pembayaran berstatus pending</p>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <p class="text-xs font-bold text-slate-400 uppercase">Pembayaran Lunas</p>
                <h2 class="text-3xl font-extrabold text-emerald-600 mt-3">
                    {{ $totalLunas }}
                </h2>
                <p class="text-xs text-slate-400 mt-2">Berhasil diverifikasi</p>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <p class="text-xs font-bold text-slate-400 uppercase">Total Pendapatan</p>
                <h2 class="text-2xl font-extrabold text-emerald-600 mt-3">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </h2>
                <p class="text-xs text-slate-400 mt-2">Dari transaksi yang lunas</p>
            </div>

        </div>

        <!-- Rejected Summary -->
        <div class="bg-rose-50 border border-rose-100 rounded-2xl px-5 py-4 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-rose-800">Pembayaran Ditolak</p>
                <p class="text-xs text-rose-600 mt-1">
                    Total transaksi yang ditolak oleh pemilik lapangan.
                </p>
            </div>
            <span class="text-2xl font-extrabold text-rose-600">
                {{ $totalDitolak }}
            </span>
        </div>

        <!-- Transaction Table -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="p-6 sm:p-8 border-b border-slate-100">
                <h2 class="font-display font-bold text-lg text-slate-900">
                    <i class="fa-solid fa-money-bill-transfer text-emerald-500 mr-2"></i>
                    Riwayat Transaksi Pembayaran
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                    Daftar pembayaran dari seluruh pelanggan Sportify.
                </p>

                <!-- Search and Filter -->
                <form action="{{ route('admin.pembayaran') }}" method="GET"
                    class="mt-5 flex flex-col md:flex-row gap-3">

                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari kode booking, pelanggan, atau lapangan..."
                        class="flex-1 rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    >

                    <select
                        name="status"
                        class="rounded-xl border border-slate-200 px-4 py-3 text-sm bg-white focus:ring-2 focus:ring-emerald-500"
                    >
                        <option value="all" {{ $status === 'all' ? 'selected' : '' }}>
                            Semua Status
                        </option>
                        <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>
                        <option value="lunas" {{ $status === 'lunas' ? 'selected' : '' }}>
                            Lunas
                        </option>
                        <option value="ditolak" {{ $status === 'ditolak' ? 'selected' : '' }}>
                            Ditolak
                        </option>
                    </select>

                    <button type="submit"
                        class="px-5 py-3 rounded-xl bg-slate-900 text-white text-sm font-bold hover:bg-slate-700 transition">
                        <i class="fa-solid fa-magnifying-glass mr-1"></i>
                        Cari
                    </button>

                    <a href="{{ route('admin.pembayaran') }}"
                        class="px-5 py-3 rounded-xl bg-slate-100 text-slate-600 text-sm font-bold text-center hover:bg-slate-200 transition">
                        Reset
                    </a>
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs whitespace-nowrap">

                    <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="px-5 py-4 font-bold">Kode Booking</th>
                            <th class="px-5 py-4 font-bold">Pelanggan</th>
                            <th class="px-5 py-4 font-bold">Lapangan</th>
                            <th class="px-5 py-4 font-bold">Metode Bayar</th>
                            <th class="px-5 py-4 font-bold">Waktu Transaksi</th>
                            <th class="px-5 py-4 font-bold">Nominal</th>
                            <th class="px-5 py-4 font-bold">Status</th>
                            <th class="px-5 py-4 font-bold text-center">Bukti</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($pembayarans as $pembayaran)
                            @php
                                $booking = $pembayaran->booking;
                                $customer = $booking?->customer;
                                $lapangan = $booking?->slot?->lapangan;

                                $statusClass = match($pembayaran->status_bayar) {
                                    'lunas' => 'bg-emerald-100 text-emerald-700',
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'ditolak' => 'bg-rose-100 text-rose-700',
                                    default => 'bg-slate-100 text-slate-600',
                                };

                                $statusLabel = match($pembayaran->status_bayar) {
                                    'lunas' => 'Lunas',
                                    'pending' => 'Pending',
                                    'ditolak' => 'Ditolak',
                                    default => ucfirst($pembayaran->status_bayar),
                                };
                            @endphp

                            <tr class="hover:bg-slate-50 transition">

                                <td class="px-5 py-5 font-extrabold text-slate-800">
                                    {{ $booking
                                        ? '#SPT-' . str_pad($booking->id_booking, 5, '0', STR_PAD_LEFT)
                                        : '-' }}
                                </td>

                                <td class="px-5 py-5">
                                    <p class="font-bold text-slate-800">
                                        {{ $customer?->nama ?? 'Pelanggan tidak tersedia' }}
                                    </p>
                                    <p class="text-slate-400 mt-1">
                                        {{ $customer?->email ?? '-' }}
                                    </p>
                                </td>

                                <td class="px-5 py-5">
                                    <p class="font-bold text-slate-800">
                                        {{ $lapangan?->nama_lapangan ?? 'Lapangan tidak tersedia' }}
                                    </p>
                                    <p class="text-slate-400 mt-1">
                                        {{ $booking?->slot?->tanggal ?? '-' }}
                                    </p>
                                </td>

                                <td class="px-5 py-5 text-slate-600">
                                    {{ ucfirst($pembayaran->metode_bayar ?? '-') }}
                                </td>

                                <td class="px-5 py-5 text-slate-600">
                                    {{ $pembayaran->waktu_transaksi
                                        ? $pembayaran->waktu_transaksi->format('d M Y, H:i')
                                        : '-' }}
                                </td>

                                <td class="px-5 py-5 font-extrabold text-slate-800">
                                    Rp {{ number_format($booking?->total_harga ?? 0, 0, ',', '.') }}
                                </td>

                                <td class="px-5 py-5">
                                    <span class="px-3 py-1.5 rounded-lg font-bold {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                <td class="px-5 py-5 text-center">
                                    @if($pembayaran->bukti_bayar)
                                        <a
                                            href="{{ asset(ltrim($pembayaran->bukti_bayar, '/')) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-blue-50 text-blue-700 font-bold hover:bg-blue-100 transition"
                                        >
                                            <i class="fa-solid fa-image"></i>
                                            Lihat
                                        </a>
                                    @else
                                        <span class="text-slate-400">Tidak ada</span>
                                    @endif
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-16 text-center">
                                    <i class="fa-solid fa-receipt text-4xl text-slate-200"></i>
                                    <p class="font-bold text-slate-500 mt-3">
                                        Belum ada transaksi pembayaran.
                                    </p>
                                    <p class="text-xs text-slate-400 mt-1">
                                        Data transaksi akan muncul setelah pelanggan mengunggah bukti pembayaran.
                                    </p>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($pembayarans->hasPages())
                <div class="p-6 border-t border-slate-100">
                    {{ $pembayarans->links() }}
                </div>
            @endif

            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                <p class="text-[11px] text-slate-400">
                    Menampilkan {{ $pembayarans->firstItem() ?? 0 }}
                    - {{ $pembayarans->lastItem() ?? 0 }}
                    dari {{ $pembayarans->total() }} transaksi.
                </p>
            </div>

        </div>

    </div>
</div>
@endsection
