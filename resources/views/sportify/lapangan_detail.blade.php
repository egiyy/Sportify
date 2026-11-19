
@extends('sportify.layouts.app')

@section('title', $lapangan->nama_lapangan . ' - Sportify')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Breadcrumb -->
        <nav class="flex items-center text-xs text-slate-500 mb-6 space-x-2">
            <a href="{{ route('home') }}" class="hover:text-sport-600 transition">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
            <span class="text-slate-400">{{ $lapangan->jenis_olahraga }}</span>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
            <span class="font-bold text-slate-900 truncate">{{ $lapangan->nama_lapangan }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8" x-data="{
    selectedSlot: null,
    modalOpen: false,
    selectedDate: @js($selectedDate),
    slotsUrl: @js(route('lapangan.slots', $lapangan->id_lapangan)),
    slots: @js($slots->values()),
    slotNotice: '',
refreshTimer: null,
bookingLoading: false,
bookingMessage: '',
bookingSuccess: false,

    init() {
        this.refreshSlots();
        this.refreshTimer = setInterval(() => {
            this.refreshSlots();
        }, 5000);
    },

    destroy() {
        clearInterval(this.refreshTimer);
    },

    async refreshSlots() {
        try {
            const response = await fetch(
                this.slotsUrl + '?tanggal=' + encodeURIComponent(this.selectedDate),
                {
                    headers: {
                        'Accept': 'application/json'
                    }
                }
            );

            if (!response.ok) return;

            const latestSlots = await response.json();
            this.slots = latestSlots;

            if (this.selectedSlot) {
                const currentSlot = latestSlots.find(
                    slot => Number(slot.id_slot) === Number(this.selectedSlot.id_slot)
                );

                if (!currentSlot || currentSlot.status_slot !== 'tersedia') {
                    this.modalOpen = false;
                    this.selectedSlot = null;
                    this.slotNotice = 'Slot yang dipilih sudah dipesan. Silakan pilih jam lain.';
                }
            }
        } catch (error) {
            console.error('Gagal memperbarui status slot:', error);
        }
        },

    formatDate(date) {
        return new Date(date + 'T00:00:00').toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
    },

        openBookingModal(slot) {
        this.selectedSlot = {
            id_slot: slot.id_slot,
            jam: slot.jam_mulai.substring(0, 5) + ' - ' + slot.jam_selesai.substring(0, 5) + ' WIB',
            tanggal: this.formatDate(this.selectedDate),
            harga: @js(\App\Helpers\Sportify::rupiah($lapangan->harga_per_jam))
        };

        this.slotNotice = '';
        this.modalOpen = true;
    },

    async submitBooking(event) {
        if (this.bookingLoading) return;

        this.bookingLoading = true;
        this.bookingMessage = '';
        this.bookingSuccess = false;

        try {
            const form = event.target;
            const formData = new FormData(form);

            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Pemesanan gagal diproses.');
            }

            this.bookingSuccess = true;
            this.bookingMessage = 'Pemesanan berhasil! Mengarahkan ke invoice...';

            await this.refreshSlots();

            window.location.href = `/booking/${result.data.id_booking}/invoice`;

        } catch (error) {
            this.bookingSuccess = false;
            this.bookingMessage = error.message;
        } finally {
            this.bookingLoading = false;
        }
    },
}">

            <!-- Left Column: Details, Photos, Reviews -->
            <div class="lg:col-span-8 space-y-8">

                <!-- Main Header Card -->
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
                    <div class="relative h-72 sm:h-96 w-full bg-slate-900">
                        <img src="{{ $lapangan->foto ?: 'https://images.unsplash.com/photo-1529900748604-07564a03e7a6?w=1200&auto=format&fit=crop&q=80' }}"
                             alt="{{ $lapangan->nama_lapangan }}"
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-dark-950/80 via-transparent to-transparent"></div>

                        <div class="absolute bottom-6 left-6 right-6 flex items-end justify-between">
                            <div>
                                <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-sport-500 text-white shadow-md">
                                    {{ $lapangan->jenis_olahraga }}
                                </span>
                                <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-white mt-2">
                                    {{ $lapangan->nama_lapangan }}
                                </h1>
                            </div>
                            <div class="text-right">
                                <span class="block text-xs text-slate-300 font-medium">Harga Sewa:</span>
                                <span class="text-xl sm:text-2xl font-extrabold text-emerald-300">
                                    {{ \App\Helpers\Sportify::rupiah($lapangan->harga_per_jam) }}
                                </span>
                                <span class="text-xs text-slate-300">/ jam</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 sm:p-8 space-y-6">
                        <!-- Key Metadata Bar -->
                        <div class="flex flex-wrap items-center justify-between gap-4 pb-6 border-b border-slate-100 text-xs">
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 font-bold border border-emerald-200">
                                    <i class="fa-solid fa-circle-check text-emerald-500 mr-1.5"></i> Terverifikasi Admin
                                </span>
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-amber-50 text-amber-700 font-bold border border-amber-200">
                                    <i class="fa-solid fa-star text-amber-500 mr-1.5"></i> {{ $lapangan->average_rating }} / 5.0 ({{ $lapangan->ulasan->count() }} Ulasan)
                                </span>
                            </div>

                            <div class="text-slate-600">
                                <i class="fa-solid fa-user-tie text-slate-400 mr-1"></i>
                                Dikelola oleh: <strong class="text-slate-900">{{ $lapangan->pemilik->nama_pemilik ?? 'Mitra Sportify' }}</strong>
                            </div>
                          </div>

                        <!-- Location -->
                        <div>
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Lokasi Lapangan</h3>
                            <p class="text-sm font-semibold text-slate-800 flex items-start">
                                <i class="fa-solid fa-location-dot text-rose-500 mr-2 mt-1 flex-shrink-0"></i>
                                <span>{{ $lapangan->lokasi }}</span>
                            </p>
                        </div>

                        <!-- Description -->
                        <div>
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi & Fasilitas</h3>
                            <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                                {{ $lapangan->deskripsi ?: 'Lapangan berkualitas prima dengan pencahayaan LED terang, ventilasi udara maksimal, lantai standar turnamen, parkir luas, dan fasilitas ruang ganti.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Customer Reviews Section -->
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-8 space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-display font-bold text-xl text-slate-900">Ulasan & Penilaian Pelanggan</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Ulasan dari pelanggan yang telah selesai bermain di lapangan ini</p>
                        </div>
                        <div class="flex items-center space-x-1 text-amber-400 text-lg">
                            <i class="fa-solid fa-star"></i>
                            <span class="font-extrabold text-slate-900 text-base ml-1">{{ $lapangan->average_rating }}</span>
                            <span class="text-xs text-slate-400">/ 5.0</span>
                        </div>
                    </div>

        @if($lapangan->ulasan->isEmpty())
                        <div class="text-center py-8 bg-slate-50 rounded-2xl border border-slate-100">
                            <i class="fa-regular fa-comment-dots text-3xl text-slate-300 mb-2"></i>
                            <p class="text-xs font-bold text-slate-600">Belum ada ulasan untuk lapangan ini.</p>
                            <p class="text-[11px] text-slate-400">Jadilah yang pertama bermain dan memberikan ulasan!</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($lapangan->ulasan as $review)
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-2.5">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 rounded-full bg-sport-100 text-sport-700 flex items-center justify-center font-bold text-xs">
                                                {{ strtoupper(substr($review->customer->nama ?? 'P', 0, 1)) }}
                                            </div>
                                            <div>
                                                <h4 class="text-xs font-bold text-slate-900">{{ $review->customer->nama ?? 'Pelanggan Sportify' }}</h4>
                                                <span class="text-[10px] text-slate-400">{{ $review->created_at->translatedFormat('d M Y, H:i') }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center text-amber-400 text-xs">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid fa-star {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-200' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-xs text-slate-700 leading-relaxed italic pl-11">
                                        "{{ $review->komentar }}"
                                    </p>

                             <!-- Owner Reply if exists -->
                                    @if($review->balasan_pemilik)
                                        <div class="ml-11 mt-2 p-3 rounded-xl bg-blue-50/80 border border-blue-100 text-xs">
                                            <div class="flex items-center space-x-1.5 text-blue-900 font-bold text-[11px] mb-1">
                                                <i class="fa-solid fa-reply fa-rotate-180 text-blue-500"></i>
                                                <span>Balasan dari Pemilik Lapangan:</span>
                                            </div>
                                            <p class="text-slate-700 text-xs">
                                                {{ $review->balasan_pemilik }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

            <!-- Right Column: Interactive Schedule & Slot Selector -->
            <div class="lg:col-span-4">
                <div class="sticky top-28 bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 space-y-6">

                    <div>
                        <span class="text-[11px] font-bold text-sport-600 uppercase tracking-wider block">PILIH JADWAL MAIN</span>
                        <h2 class="font-display font-extrabold text-xl text-slate-900">Ketersediaan Slot Jam</h2>
                        <p class="text-xs text-slate-500 mt-1">Pilih tanggal dan jam bermain yang Anda inginkan.</p>
                    </div>

                    <!-- Date Selection Pills -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 block">Pilih Tanggal:</label>
                        <div class="grid grid-cols-4 gap-1.5">
                 @for($i = 0; $i < 4; $i++)
                                @php
                                    $d = \Carbon\Carbon::today()->addDays($i);
                                    $dateStr = $d->toDateString();
                                    $isSelected = ($selectedDate === $dateStr);
                                @endphp
                                <a href="{{ route('lapangan.detail', ['id' => $lapangan->id_lapangan, 'tanggal' => $dateStr]) }}"
                                   class="py-2 px-1 text-center rounded-xl border text-xs font-bold transition {{ $isSelected ? 'bg-sport-600 text-white border-sport-600 shadow-sm' : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100' }}">
                                    <span class="block text-[10px] font-normal {{ $isSelected ? 'text-emerald-100' : 'text-slate-500' }}">
                                        {{ $i === 0 ? 'Hari Ini' : ($i === 1 ? 'Besok' : $d->translatedFormat('D')) }}
                                    </span>
                                    <span class="block text-xs font-bold">{{ $d->format('d M') }}</span>
                                </a>
                            @endfor
                        </div>
                    </div>

                    <!-- Slots Grid -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                            <span>Slot Jam ({{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}):</span>
                            <span class="text-[10px] text-slate-400 font-normal">Klik slot untuk pesan</span>
                        </div>

                        <div class="grid grid-cols-2 gap-2 max-h-96 overflow-y-auto pr-1">
                           <template x-for="slot in slots" :key="slot.id_slot">
    <button
        type="button"
        :disabled="slot.status_slot !== 'tersedia'"
        @click="openBookingModal(slot)"
        class="w-full p-2.5 rounded-xl border text-left transition"
        :class="slot.status_slot === 'tersedia'
            ? 'border-emerald-300 bg-emerald-50 hover:bg-emerald-500 hover:text-white hover:border-emerald-500'
            : 'border-rose-200 bg-rose-50 opacity-75 cursor-not-allowed'"
    >
        <div class="flex items-center justify-between text-xs font-extrabold"
             :class="slot.status_slot === 'tersedia' ? 'text-emerald-900' : 'text-rose-800'">

            <span x-text="slot.jam_mulai.substring(0, 5) + ' - ' + slot.jam_selesai.substring(0, 5)"></span>

            <i class="fa-solid"
               :class="slot.status_slot === 'tersedia'
                   ? 'fa-circle-check text-emerald-600'
                   : 'fa-circle-xmark text-rose-500'">
            </i>
        </div>

        <span
            class="text-[10px] font-semibold block mt-0.5"
            :class="slot.status_slot === 'tersedia' ? 'text-emerald-700' : 'text-rose-600'"
            x-text="slot.status_slot === 'tersedia' ? 'Tersedia' : 'Sudah Dibooking'">
        </span>
    </button>
</template>

                                <template x-if="slot.status_slot !== 'tersedia'">
                                    <div class="p-2.5 rounded-xl border border-rose-200 bg-rose-50 text-left opacity-75 cursor-not-allowed">
                                        <div class="flex items-center justify-between text-xs font-bold text-rose-800">
                                            <span x-text="slot.jam_mulai.substring(0, 5) + ' - ' + slot.jam_selesai.substring(0, 5)"></span>
                                            <i class="fa-solid fa-circle-xmark text-[10px] text-rose-500"></i>
                                        </div>
                                        <span class="text-[10px] font-semibold text-rose-600 block mt-0.5">
                                            Dibooking
                                        </span>
                                       </div>
                                </template>
                            </template>
                        </div>

                        <p x-show="slotNotice"
                           x-text="slotNotice"
                           class="text-xs font-semibold text-rose-600 mt-2"></p>
                    </div>

                    <!-- Legend -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-around text-[11px] text-slate-500">
                        <div class="flex items-center space-x-1.5">
                            <span class="w-3 h-3 rounded bg-emerald-500"></span>
                            <span>Tersedia</span>
                        </div>
                        <div class="flex items-center space-x-1.5">
                            <span class="w-3 h-3 rounded bg-rose-400"></span>
                            <span>Sudah Dibooking</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Booking Modal (Interactive Drawer) -->
            <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">

                    <!-- Backdrop -->
                    <div x-show="modalOpen"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="ease-in duration-200"
                           x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         @click="modalOpen = false"
                         class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm transition-opacity"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div x-show="modalOpen"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-100">

                        <!-- Modal Header -->
                        <div class="bg-gradient-to-r from-dark-900 to-slate-800 p-6 text-white flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-sport-500 text-white flex items-center justify-center font-bold text-lg">
                                    <i class="fa-solid fa-calendar-check"></i>
                                </div>
                                <div>
                                    <h3 class="font-display font-extrabold text-lg text-white">Konfirmasi Pemesanan</h3>
                                    <p class="text-xs text-slate-300">{{ $lapangan->nama_lapangan }}</p>
                                </div>
                            </div>
                            <button @click="modalOpen = false" class="text-slate-400 hover:text-white p-1">
                                <i class="fa-solid fa-xmark text-lg"></i>
                            </button>
                        </div>

                        @if(!session()->has('sportify_user_id') || session('sportify_user_role') !== 'customer')
                            <div class="p-6 text-center space-y-4">
                                 <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mx-auto text-xl">
                                    <i class="fa-solid fa-lock"></i>
                                </div>
                                <h4 class="text-base font-bold text-slate-900">Silakan Masuk Terlebih Dahulu</h4>
                                <p class="text-xs text-slate-600 max-w-sm mx-auto">
                                    Untuk melanjutkan pemesanan slot ini, Anda harus masuk sebagai akun Pelanggan (Customer).
                                </p>
                                <div class="pt-2 flex items-center justify-center space-x-3">
                                    <a href="{{ route('demo.login', 'customer') }}" class="px-4 py-2.5 rounded-xl bg-sport-600 text-white font-bold text-xs hover:bg-sport-700 transition">
                                        <i class="fa-solid fa-user mr-1.5"></i> Login Cepat (Customer)
                                    </a>
                                    <a href="{{ route('login') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition">
                                        Masuk Biasa
                                    </a>
                                </div>
                            </div>
                        @else

<form action="{{ route('booking.store') }}"
      method="POST"
      class="p-6 space-y-5"
      @submit.prevent="submitBooking($event)">

    @csrf
    <input type="hidden" name="id_slot" :value="selectedSlot?.id_slot">

    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3 text-xs">
        <div class="flex items-center justify-between pb-2 border-b border-slate-200">
            <span class="text-slate-500">Nama Pelanggan:</span>
            <span class="font-bold text-slate-900">{{ session('sportify_user_name') }}</span>
        </div>

        <div class="flex items-center justify-between pb-2 border-b border-slate-200">
            <span class="text-slate-500">Tanggal Main:</span>
            <span class="font-bold text-slate-900" x-text="selectedSlot?.tanggal"></span>
        </div>

        <div class="flex items-center justify-between pb-2 border-b border-slate-200">
            <span class="text-slate-500">Jam Main:</span>
            <span class="font-bold text-emerald-600" x-text="selectedSlot?.jam"></span>
        </div>

        <div class="flex items-center justify-between pt-1 text-sm">
            <span class="font-bold text-slate-900">Total Biaya Sewa:</span>
            <span class="font-extrabold text-sport-600 text-base" x-text="selectedSlot?.harga"></span>
        </div>
    </div>

    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1">
            Catatan Tambahan (Opsional):
        </label>

        <textarea name="catatan"
                  rows="2"
                  placeholder="Contoh: Butuh rompi tambahan."
                  class="w-full p-3 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-sport-500 focus:outline-none"></textarea>
    </div>

    <div class="p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-[11px] flex items-start space-x-2">
        <i class="fa-solid fa-gift text-amber-500 mt-0.5"></i>
        <span>
            Pemesanan ini akan memberikan Anda
            <strong class="font-bold">100 Poin Loyalitas</strong>
            setelah pembayaran diverifikasi oleh pemilik lapangan!
        </span>
    </div>

    <p x-show="bookingMessage"
       x-text="bookingMessage"
       class="text-xs font-semibold"
       :class="bookingSuccess ? 'text-emerald-600' : 'text-rose-600'"></p>

    <div class="pt-2 flex items-center justify-end space-x-3">
        <button type="button"
                @click="modalOpen = false"
                :disabled="bookingLoading"
                class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-bold text-xs hover:bg-slate-50">
            Batal
        </button>

        <button type="submit"
                :disabled="bookingLoading"
                class="px-6 py-2.5 rounded-xl bg-sport-600 hover:bg-sport-700 text-white font-bold text-xs shadow-md transition disabled:opacity-50">
            <span x-show="!bookingLoading">
                Lanjut ke Pembayaran
                <i class="fa-solid fa-arrow-right ml-1"></i>
            </span>
            <span x-show="bookingLoading">
                Memproses...
            </span>
        </button>
    </div>
</form>

                        @endif

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
