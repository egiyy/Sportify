@extends('sportify.layouts.app')

@section('title', 'Pembayaran Booking #' . $booking->id_booking . ' - Sportify')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8 text-center sm:text-left flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-xs font-bold text-sport-600 uppercase tracking-wider block">LANGKAH 2 DARI 2</span>
                <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                    Selesaikan Pembayaran
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Kode Booking: <strong class="text-slate-900 font-mono">#SPT-{{ str_pad($booking->id_booking, 5, '0', STR_PAD_LEFT) }}</strong>
                </p>
            </div>
            <div>
                <a href="{{ route('customer.bookings') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition shadow-sm">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Ke Pesanan Saya
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left: Order Summary & Bank Accounts -->
            <div class="lg:col-span-7 space-y-6">
                
                <!-- Order Summary Card -->
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 space-y-4">
                    <h3 class="font-display font-bold text-base text-slate-900 pb-3 border-b border-slate-100 flex items-center">
                        <i class="fa-solid fa-receipt text-sport-500 mr-2"></i> Ringkasan Pesanan Lapangan
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Nama Lapangan:</span>
                            <span class="font-bold text-slate-900">{{ $booking->slot->lapangan->nama_lapangan }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Kategori Olahraga:</span>
                            <span class="font-bold text-slate-900">{{ $booking->slot->lapangan->jenis_olahraga }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Tanggal Bermain:</span>
                            <span class="font-bold text-slate-900">{{ \Carbon\Carbon::parse($booking->slot->tanggal)->translatedFormat('l, d F Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Slot Jam:</span>
                            <span class="font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-lg border border-emerald-200">
                                {{ substr($booking->slot->jam_mulai, 0, 5) }} - {{ substr($booking->slot->jam_selesai, 0, 5) }} WIB
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Venue / Pemilik:</span>
                            <span class="font-semibold text-slate-800">{{ $booking->slot->lapangan->pemilik->nama_pemilik }}</span>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-sm">
                            <span class="font-bold text-slate-900">Total Tagihan:</span>
                            <span class="font-extrabold text-xl text-sport-600">
                                {{ \App\Helpers\Sportify::rupiah($booking->total_harga) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods Info Card -->
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 space-y-4">
                    <h3 class="font-display font-bold text-base text-slate-900 pb-3 border-b border-slate-100 flex items-center">
                        <i class="fa-solid fa-building-columns text-blue-500 mr-2"></i> Pilihan Rekening Pembayaran
                    </h3>

                    <div class="space-y-3">
                        <!-- BCA -->
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] font-extrabold text-blue-600 uppercase tracking-wider block">BANK BCA</span>
                                <span class="font-mono text-sm font-bold text-slate-900">827-091-2345</span>
                                <span class="block text-[11px] text-slate-500">a.n. SPORTIFY INDONESIA</span>
                            </div>
                            <button type="button" onclick="navigator.clipboard.writeText('8270912345'); alert('Nomor rekening BCA disalin!');" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-100 transition shadow-sm">
                                <i class="fa-regular fa-copy mr-1"></i> Salin
                            </button>
                        </div>

                        <!-- Mandiri -->
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] font-extrabold text-amber-600 uppercase tracking-wider block">BANK MANDIRI</span>
                                <span class="font-mono text-sm font-bold text-slate-900">112-00-889977-1</span>
                                <span class="block text-[11px] text-slate-500">a.n. SPORTIFY INDONESIA</span>
                            </div>
                            <button type="button" onclick="navigator.clipboard.writeText('112008899771'); alert('Nomor rekening Mandiri disalin!');" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-100 transition shadow-sm">
                                <i class="fa-regular fa-copy mr-1"></i> Salin
                            </button>
                        </div>

                        <!-- QRIS -->
                        <div class="p-3.5 rounded-2xl bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-sport-500 text-white flex items-center justify-center font-bold text-base">
                                    <i class="fa-solid fa-qrcode"></i>
                                </div>
                                <div>
                                    <span class="text-xs font-extrabold text-emerald-900 block">QRIS SPORTIFY (Semua E-Wallet)</span>
                                    <span class="text-[11px] text-emerald-700">GoPay, OVO, Dana, ShopeePay, BCA Mobile</span>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-200 text-emerald-800">Instan</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right: Upload Bukti Transfer Form -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xl p-6 sm:p-8 space-y-6" x-data="{ 
                    photoPreview: '{{ $booking->pembayaran?->bukti_bayar ?? '' }}',
                    handleFileSelect(event) {
                        const file = event.target.files[0];
                        if (file) {
                            this.photoPreview = URL.createObjectURL(file);
                        }
                    }
                }">
                    <div>
                        <span class="text-xs font-bold text-sport-600 uppercase tracking-wider block">VERIFIKASI MANUAL</span>
                        <h2 class="font-display font-extrabold text-xl text-slate-900">Unggah Bukti Bayar</h2>
                        <p class="text-xs text-slate-500 mt-1">
                            Foto bukti struk ATM, tangkapan layar m-Banking atau QRIS Anda.
                        </p>
                    </div>

                    @if($booking->pembayaran && $booking->pembayaran->status_bayar === 'lunas')
                        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-center space-y-2">
                            <i class="fa-solid fa-circle-check text-4xl text-emerald-500"></i>
                            <h4 class="font-bold text-sm">Pembayaran Telah Lunas!</h4>
                            <p class="text-xs text-emerald-700">Pesanan Anda telah dikonfirmasi dan diverifikasi oleh pemilik lapangan.</p>
                            <a href="{{ route('booking.invoice', $booking->id_booking) }}" target="_blank" class="inline-block mt-2 px-4 py-2 rounded-xl bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-700 transition">
                                <i class="fa-solid fa-print mr-1"></i> Cetak Invoice
                            </a>
                        </div>
                    @else
                        <form action="{{ route('pembayaran.store', $booking->id_booking) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                            @csrf

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Metode Pembayaran yang Digunakan:</label>
                                <select name="metode_bayar" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sport-500">
                                    <option value="Transfer Bank BCA" {{ ($booking->pembayaran?->metode_bayar === 'Transfer Bank BCA') ? 'selected' : '' }}>Transfer Bank BCA</option>
                                    <option value="Transfer Bank Mandiri" {{ ($booking->pembayaran?->metode_bayar === 'Transfer Bank Mandiri') ? 'selected' : '' }}>Transfer Bank Mandiri</option>
                                    <option value="Transfer Bank BRI" {{ ($booking->pembayaran?->metode_bayar === 'Transfer Bank BRI') ? 'selected' : '' }}>Transfer Bank BRI</option>
                                    <option value="QRIS" {{ ($booking->pembayaran?->metode_bayar === 'QRIS') ? 'selected' : '' }}>QRIS (Semua E-Wallet / Mobile Banking)</option>
                                    <option value="Tunai / Cash" {{ ($booking->pembayaran?->metode_bayar === 'Tunai / Cash') ? 'selected' : '' }}>Bayar Tunai di Lokasi (Cash)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">File Foto Bukti Pembayaran:</label>
                                
                                <div class="relative border-2 border-dashed border-slate-300 rounded-2xl p-6 text-center hover:border-sport-500 transition bg-slate-50/50 cursor-pointer">
                                    <input type="file" name="bukti_bayar" accept="image/*" required @change="handleFileSelect" 
                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    
                                    <template x-if="!photoPreview">
                                        <div class="space-y-2">
                                            <div class="w-12 h-12 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center mx-auto text-xl">
                                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                            </div>
                                            <p class="text-xs font-bold text-slate-700">Pilih atau Seret Foto ke Sini</p>
                                            <p class="text-[10px] text-slate-400">Format: JPG, PNG, WEBP (Maks 3MB)</p>
                                        </div>
                                    </template>

                                    <template x-if="photoPreview">
                                        <div class="space-y-3">
                                            <img :src="photoPreview" alt="Pratinjau Bukti" class="max-h-48 mx-auto rounded-xl object-contain shadow-md border border-slate-200">
                                            <p class="text-[11px] font-bold text-sport-600">
                                                <i class="fa-solid fa-check-circle mr-1"></i> Foto berhasil dipilih. Klik untuk ganti.
                                            </p>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-sport-600 hover:bg-sport-700 text-white font-bold text-xs tracking-wider uppercase shadow-md shadow-sport-600/30 transition">
                                <i class="fa-solid fa-upload mr-1.5"></i> Kirim Bukti Pembayaran
                            </button>
                        </form>
                    @endif

                </div>
            </div>

        </div>

    </div>
</div>
@endsection
