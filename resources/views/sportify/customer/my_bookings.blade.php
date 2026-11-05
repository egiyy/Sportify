@extends('sportify.layouts.app')

@section('title', 'Pesanan Saya - Sportify')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen" x-data="{ 
    reviewModalOpen: false, 
    selectedBookingId: null,
    selectedLapanganName: '',
    rating: 5,
    openReviewModal(id, name) {
        this.selectedBookingId = id;
        this.selectedLapanganName = name;
        this.rating = 5;
        this.reviewModalOpen = true;
    }
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Title & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-bold text-sport-600 uppercase tracking-wider block">RIWAYAT AKTIVITAS</span>
                <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                    Pesanan Lapangan Saya
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Kelola dan pantau status pemesanan jadwal olahraga Anda.
                </p>
            </div>
            <div>
                <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-sport-600 hover:bg-sport-700 text-white font-bold text-xs shadow-md shadow-sport-600/30 transition">
                    <i class="fa-solid fa-plus mr-1.5"></i> Pesan Lapangan Baru
                </a>
            </div>
        </div>

        <!-- Filter Status Pills -->
        <div class="flex flex-wrap items-center gap-2 mb-6">
            <span class="text-xs font-bold text-slate-500 mr-1">Status:</span>
            <a href="{{ route('customer.bookings') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ !request('status') || request('status') === 'all' ? 'bg-slate-900 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Semua
            </a>
            <a href="{{ route('customer.bookings', ['status' => 'pending']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === 'pending' ? 'bg-amber-500 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Menunggu Verifikasi
            </a>
            <a href="{{ route('customer.bookings', ['status' => 'confirmed']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === 'confirmed' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Terkonfirmasi
            </a>
            <a href="{{ route('customer.bookings', ['status' => 'completed']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === 'completed' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Selesai
            </a>
            <a href="{{ route('customer.bookings', ['status' => 'cancelled']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === 'cancelled' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Dibatalkan
            </a>
        </div>

        @if($bookings->isEmpty())
            <div class="text-center py-16 bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fa-solid fa-calendar-xmark"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800">Belum ada pesanan</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    Anda belum memiliki riwayat pemesanan lapangan pada kategori ini.
                </p>
                <a href="{{ route('home') }}" class="mt-4 inline-block px-5 py-2.5 rounded-xl bg-sport-600 text-white text-xs font-bold hover:bg-sport-700 transition">
                    Cari Lapangan Sekarang
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($bookings as $booking)
                    @php
                        $lapangan = $booking->slot->lapangan;
                        $slot = $booking->slot;
                        $pembayaran = $booking->pembayaran;
                    @endphp

                    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 flex flex-col md:flex-row md:items-center justify-between gap-6 hover:border-slate-300 transition">
                        
                        <!-- Left Info -->
                        <div class="flex items-start space-x-4">
                            <div class="w-14 h-14 rounded-2xl bg-slate-100 text-sport-600 flex items-center justify-center text-2xl flex-shrink-0">
                                @if(strtolower($lapangan->jenis_olahraga) === 'futsal')
                                    ⚽
                                @elseif(strtolower($lapangan->jenis_olahraga) === 'badminton')
                                    🏸
                                @elseif(strtolower($lapangan->jenis_olahraga) === 'basket')
                                    🏀
                                @else
                                    🏟️
                                @endif
                            </div>

                            <div class="space-y-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="font-mono text-xs font-extrabold text-slate-500">
                                        #SPT-{{ str_pad($booking->id_booking, 5, '0', STR_PAD_LEFT) }}
                                    </span>
                                    
                                    <!-- Status Badges -->
                                    @if($booking->status_booking === 'pending')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800 border border-amber-200">
                                            <i class="fa-solid fa-clock mr-1"></i> Menunggu Verifikasi
                                        </span>
                                    @elseif($booking->status_booking === 'confirmed')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-100 text-blue-800 border border-blue-200">
                                            <i class="fa-solid fa-circle-check mr-1"></i> Terkonfirmasi
                                        </span>
                                    @elseif($booking->status_booking === 'completed')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            <i class="fa-solid fa-flag-checkered mr-1"></i> Selesai
                                        </span>
                                    @elseif($booking->status_booking === 'cancelled')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800 border border-rose-200">
                                            <i class="fa-solid fa-ban mr-1"></i> Dibatalkan
                                        </span>
                                    @endif

                                    <!-- Pembayaran Status -->
                                    @if($pembayaran)
                                        @if($pembayaran->status_bayar === 'lunas')
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700">
                                                Lunas
                                            </span>
                                        @elseif($pembayaran->status_bayar === 'pending')
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-700">
                                                Bukti Diunggah
                                            </span>
                                        @elseif($pembayaran->status_bayar === 'ditolak')
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-50 text-rose-700">
                                                Ditolak
                                            </span>
                                        @endif
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600">
                                            Belum Bayar
                                        </span>
                                    @endif
                                </div>

                                <h3 class="font-display font-bold text-base text-slate-900">
                                    {{ $lapangan->nama_lapangan }}
                                </h3>

                                <div class="text-xs text-slate-500 space-y-0.5">
                                    <p class="flex items-center">
                                        <i class="fa-regular fa-calendar text-slate-400 mr-2 w-3.5"></i>
                                        <span>{{ \Carbon\Carbon::parse($slot->tanggal)->translatedFormat('l, d F Y') }}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <i class="fa-regular fa-clock text-slate-400 mr-2 w-3.5"></i>
                                        <span class="font-semibold text-slate-700">
                                            {{ substr($slot->jam_mulai, 0, 5) }} - {{ substr($slot->jam_selesai, 0, 5) }} WIB
                                        </span>
                                    </p>
                                </div>

                                <!-- Review Feedback Display if Reviewed -->
                                @if($booking->ulasan)
                                    <div class="mt-2 p-2.5 rounded-xl bg-amber-50/80 border border-amber-200/60 text-xs">
                                        <div class="flex items-center text-amber-500 space-x-1 mb-1">
                                            <span class="font-bold text-slate-800 text-[11px] mr-1">Ulasan Anda:</span>
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid fa-star text-[10px] {{ $i <= $booking->ulasan->rating ? 'text-amber-400' : 'text-slate-200' }}"></i>
                                            @endfor
                                        </div>
                                        <p class="text-slate-700 italic text-[11px]">"{{ $booking->ulasan->komentar }}"</p>
                                        @if($booking->ulasan->balasan_pemilik)
                                            <div class="mt-1 pt-1 border-t border-amber-200/60 text-[10px] text-blue-800">
                                                <strong class="font-bold">Balasan Pemilik:</strong> {{ $booking->ulasan->balasan_pemilik }}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Right Actions & Total -->
                        <div class="flex flex-col sm:items-end justify-between space-y-3 pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                            <div>
                                <span class="block text-[10px] text-slate-400 font-medium sm:text-right">Total Biaya:</span>
                                <span class="text-lg font-extrabold text-sport-600 sm:text-right block">
                                    {{ \App\Helpers\Sportify::rupiah($booking->total_harga) }}
                                </span>
                            </div>

                            <div class="flex flex-wrap items-center gap-2">
                                @if($booking->status_booking === 'pending')
                                    <a href="{{ route('pembayaran.show', $booking->id_booking) }}" class="px-3.5 py-2 rounded-xl bg-sport-600 hover:bg-sport-700 text-white font-bold text-xs transition shadow-sm">
                                        <i class="fa-solid fa-upload mr-1"></i> {{ $pembayaran ? 'Ganti Bukti Bayar' : 'Bayar Sekarang' }}
                                    </a>

                                    <form action="{{ route('booking.cancel', $booking->id_booking) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?');">
                                        @csrf
                                        <button type="submit" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 font-bold text-xs transition border border-slate-200">
                                            Batal
                                        </button>
                                    </form>
                                @endif

                                @if($booking->status_booking === 'confirmed' || $booking->status_booking === 'completed')
                                    <a href="{{ route('booking.invoice', $booking->id_booking) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs transition shadow-sm">
                                        <i class="fa-solid fa-receipt mr-1"></i> Invoice
                                    </a>
                                @endif

                                @if($booking->status_booking === 'completed' && !$booking->ulasan)
                                    <button type="button" @click="openReviewModal({{ $booking->id_booking }}, '{{ $lapangan->nama_lapangan }}')" class="px-3.5 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-xs transition shadow-sm">
                                        <i class="fa-solid fa-star mr-1"></i> Beri Ulasan
                                    </button>
                                @endif
                            </div>
                        </div>

                    </div>
                @endforeach

                <div class="pt-4">
                    {{ $bookings->links() }}
                </div>
            </div>
        @endif

    </div>

    <!-- Review Modal -->
    <div x-show="reviewModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="reviewModalOpen" @click="reviewModalOpen = false" class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div x-show="reviewModalOpen" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-100">
                <div class="bg-gradient-to-r from-dark-900 to-slate-800 p-6 text-white flex items-center justify-between">
                    <div>
                        <h3 class="font-display font-extrabold text-lg text-white">Beri Ulasan & Penilaian</h3>
                        <p class="text-xs text-slate-300" x-text="selectedLapanganName"></p>
                    </div>
                    <button @click="reviewModalOpen = false" class="text-slate-400 hover:text-white">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form action="{{ route('ulasan.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    <input type="hidden" name="id_booking" :value="selectedBookingId">
                    <input type="hidden" name="rating" :value="rating">

                    <!-- Rating Stars -->
                    <div class="text-center py-2">
                        <label class="block text-xs font-bold text-slate-600 mb-2">Penilaian Bintang:</label>
                        <div class="flex items-center justify-center space-x-2 text-2xl">
                            <template x-for="i in 5">
                                <button type="button" @click="rating = i" class="focus:outline-none transition-transform hover:scale-125">
                                    <i class="fa-solid fa-star" :class="i <= rating ? 'text-amber-400' : 'text-slate-200'"></i>
                                </button>
                            </template>
                        </div>
                        <span class="block text-xs font-bold text-amber-600 mt-1" x-text="rating + ' dari 5 Bintang'"></span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pengalaman / Komentar Anda:</label>
                        <textarea name="komentar" rows="3" required placeholder="Bagikan kesan mengenai kebersihan, rumput, pencahayaan, atau pelayanan lapangan..."
                                  class="w-full p-3 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-sport-500 focus:outline-none"></textarea>
                    </div>

                    <div class="p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-[11px] flex items-center space-x-2">
                        <i class="fa-solid fa-gift text-amber-500"></i>
                        <span>Anda akan mendapatkan bonus <strong class="font-bold">20 Poin Loyalitas</strong> setelah mengirimkan ulasan!</span>
                    </div>

                    <div class="pt-2 flex items-center justify-end space-x-3">
                        <button type="button" @click="reviewModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-700 font-bold text-xs hover:bg-slate-50">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-sport-600 hover:bg-sport-700 text-white font-bold text-xs shadow-md shadow-sport-600/30 transition">
                            Kirim Ulasan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
