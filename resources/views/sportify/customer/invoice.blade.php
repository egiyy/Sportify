<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #SPT-{{ str_pad($booking->id_booking, 5, '0', STR_PAD_LEFT) }} - Sportify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .invoice-box { box-shadow: none !important; border: none !important; padding: 0 !important; }
        }
    </style>
</head>
<body class="bg-slate-100 py-10 text-slate-800">

    <div class="max-w-3xl mx-auto px-4">
        
        <!-- Action Buttons -->
        <div class="mb-6 flex items-center justify-between no-print">
            <a href="{{ route('customer.bookings') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition shadow-sm">
                <i class="fa-solid fa-arrow-left mr-1.5"></i> Kembali ke Pesanan
            </a>
            <button onclick="window.print()" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition">
                <i class="fa-solid fa-print mr-1.5"></i> Cetak / Simpan PDF
            </button>
        </div>

        <!-- Invoice Container -->
        <div class="invoice-box bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-slate-200/90 relative overflow-hidden">
            
            <!-- Watermark / Stamp -->
            <div class="absolute right-8 top-32 rotate-[-15deg] opacity-10 pointer-events-none">
                <div class="border-8 border-emerald-600 text-emerald-600 px-6 py-2 rounded-2xl font-black text-5xl uppercase tracking-widest">
                    {{ $booking->pembayaran?->status_bayar === 'lunas' ? 'LUNAS' : 'BOOKED' }}
                </div>
            </div>

            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-start justify-between pb-8 border-b border-slate-200 gap-6">
                <div>
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center text-white font-bold text-lg">
                            <i class="fa-solid fa-futbol"></i>
                        </div>
                        <span class="font-bold text-2xl tracking-tight text-slate-900">
                            SPORT<span class="text-emerald-500">IFY</span>
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">
                        Sistem Pemesanan Lapangan Futsal & Olahraga Terpadu<br>
                        Universitas Lampung, Bandar Lampung
                    </p>
                </div>

                <div class="sm:text-right">
                    <span class="text-xs font-extrabold text-emerald-600 uppercase tracking-widest block">INVOICE PEMESANAN</span>
                    <h2 class="font-mono text-xl font-bold text-slate-900 mt-1">
                        #SPT-{{ str_pad($booking->id_booking, 5, '0', STR_PAD_LEFT) }}
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB
                    </p>
                </div>
            </div>

            <!-- Customer & Venue Details -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 py-8 border-b border-slate-200 text-xs">
                <div>
                    <span class="font-bold text-slate-400 uppercase tracking-wider block mb-2">Ditujukan Kepada:</span>
                    <h3 class="font-bold text-sm text-slate-900">{{ $booking->customer->nama }}</h3>
                    <p class="text-slate-600 mt-1">Email: {{ $booking->customer->email }}</p>
                    <p class="text-slate-600">WhatsApp: {{ $booking->customer->no_wa ?? '-' }}</p>
                </div>

                <div>
                    <span class="font-bold text-slate-400 uppercase tracking-wider block mb-2">Detail Tempat (Venue):</span>
                    <h3 class="font-bold text-sm text-slate-900">{{ $booking->slot->lapangan->nama_lapangan }}</h3>
                    <p class="text-slate-600 mt-1">Pengelola: {{ $booking->slot->lapangan->pemilik->nama_pemilik }}</p>
                    <p class="text-slate-600">Lokasi: {{ $booking->slot->lapangan->lokasi }}</p>
                </div>
            </div>

            <!-- Table of Services -->
            <div class="py-8 border-b border-slate-200">
                <table class="w-full text-xs text-left">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 uppercase tracking-wider">
                            <th class="pb-3 font-bold">Deskripsi Sewa</th>
                            <th class="pb-3 font-bold text-center">Jadwal Main</th>
                            <th class="pb-3 font-bold text-right">Tarif</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr>
                            <td class="py-4">
                                <span class="font-bold text-slate-900 text-sm block">{{ $booking->slot->lapangan->nama_lapangan }}</span>
                                <span class="text-slate-500">Cabang Olahraga: {{ $booking->slot->lapangan->jenis_olahraga }}</span>
                            </td>
                            <td class="py-4 text-center">
                                <span class="font-bold text-slate-800 block">{{ \Carbon\Carbon::parse($booking->slot->tanggal)->translatedFormat('d M Y') }}</span>
                                <span class="text-emerald-700 font-semibold bg-emerald-50 px-2 py-0.5 rounded text-[11px]">
                                    {{ substr($booking->slot->jam_mulai, 0, 5) }} - {{ substr($booking->slot->jam_selesai, 0, 5) }} WIB
                                </span>
                            </td>
                            <td class="py-4 text-right font-bold text-slate-900">
                                {{ \App\Helpers\Sportify::rupiah($booking->total_harga) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Summary & Payment Info -->
            <div class="pt-6 grid grid-cols-1 sm:grid-cols-2 gap-8 items-start">
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs space-y-2">
                    <span class="font-bold text-slate-700 block">Status Pembayaran:</span>
                    <div class="flex items-center space-x-2">
                        <span class="px-2.5 py-1 rounded-full font-extrabold text-[11px] {{ $booking->pembayaran?->status_bayar === 'lunas' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ strtoupper($booking->pembayaran?->status_bayar ?? 'PENDING') }}
                        </span>
                        <span class="text-slate-600 font-semibold">Via {{ $booking->pembayaran?->metode_bayar ?? 'Transfer' }}</span>
                    </div>
                    @if($booking->pembayaran?->catatan_verifikasi)
                        <p class="text-[11px] text-slate-500 pt-1 italic">
                            Catatan: {{ $booking->pembayaran->catatan_verifikasi }}
                        </p>
                    @endif
                </div>

                <div class="text-right space-y-2">
                    <div class="flex justify-between text-xs text-slate-500">
                        <span>Subtotal Sewa:</span>
                        <span class="font-bold text-slate-800">{{ \App\Helpers\Sportify::rupiah($booking->total_harga) }}</span>
                    </div>
                    <div class="flex justify-between text-xs text-slate-500">
                        <span>Biaya Layanan:</span>
                        <span class="font-bold text-emerald-600">Gratis (Rp 0)</span>
                    </div>
                    <div class="flex justify-between text-sm font-extrabold text-slate-900 pt-2 border-t border-slate-200">
                        <span>Total Bayar:</span>
                        <span class="text-lg text-emerald-600">{{ \App\Helpers\Sportify::rupiah($booking->total_harga) }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer Notes -->
            <div class="mt-12 pt-6 border-t border-slate-100 text-[11px] text-slate-400 text-center">
                <p>Terima kasih telah menggunakan platform SPORTIFY. Tunjukkan struk invoice ini saat tiba di lokasi venue olahraga.</p>
                <p class="mt-1">Proyek Pemrograman Web Lanjut &copy; {{ date('Y') }} Jurusan Ilmu Komputer UNILA</p>
            </div>

        </div>

    </div>

</body>
</html>
