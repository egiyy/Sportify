@extends('sportify.layouts.app')

@section('title', 'Manajemen Slot Jadwal Lapangan - Sportify')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('pemilik.dashboard') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition mb-1 inline-block">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Dashboard Pemilik
                </a>
                <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                    Manajemen Slot Jadwal Lapangan
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Buka atau tutup jam sewa lapangan dan pantau ketersediaan slot bermain.
                </p>
            </div>
        </div>

        @if($myLapangans->isEmpty())
            <div class="text-center py-16 bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
                <i class="fa-solid fa-futbol text-4xl text-slate-300 mb-3"></i>
                <h3 class="font-bold text-base text-slate-800">Anda belum memiliki lapangan</h3>
                <p class="text-xs text-slate-500 mt-1 mb-4">Silakan daftarkan lapangan terlebih dahulu sebelum mengatur slot jadwal.</p>
                <a href="{{ route('pemilik.lapangan.create') }}" class="px-4 py-2 bg-sport-600 text-white rounded-xl text-xs font-bold">
                    Tambah Lapangan
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left: Filter & Slots List Table -->
                <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden p-6 sm:p-8 space-y-6">
                    
                    <!-- Filter Bar -->
                    <form action="{{ route('pemilik.slots') }}" method="GET" class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row items-center gap-3">
                        <div class="flex-1 w-full">
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Pilih Lapangan:</label>
                            <select name="id_lapangan" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sport-500">
                                @foreach($myLapangans as $lap)
                                    <option value="{{ $lap->id_lapangan }}" {{ $selectedLapanganId == $lap->id_lapangan ? 'selected' : '' }}>
                                        {{ $lap->nama_lapangan }} ({{ $lap->jenis_olahraga }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-full sm:w-48">
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Pilih Tanggal:</label>
                            <input type="date" name="tanggal" value="{{ $selectedDate }}" onchange="this.form.submit()" 
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sport-500">
                        </div>
                    </form>

                    <!-- Slot Table -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-display font-bold text-base text-slate-900">
                                Daftar Slot ({{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }})
                            </h3>
                            <span class="text-xs text-slate-500 font-semibold">
                                Total: {{ $slots->count() }} Slot
                            </span>
                        </div>

                        @if($slots->isEmpty())
                            <div class="text-center py-10 bg-slate-50 rounded-2xl border border-slate-100">
                                <i class="fa-regular fa-clock text-3xl text-slate-300 mb-2"></i>
                                <p class="text-xs font-bold text-slate-600">Belum ada slot pada tanggal ini.</p>
                                <p class="text-[11px] text-slate-400">Gunakan form di samping untuk menambahkan slot jam sewa baru.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-xs text-left">
                                    <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px] border-b border-slate-100">
                                        <tr>
                                            <th class="px-4 py-2.5 font-bold">Jam Mulai</th>
                                            <th class="px-4 py-2.5 font-bold">Jam Selesai</th>
                                            <th class="px-4 py-2.5 font-bold">Status Slot</th>
                                            <th class="px-4 py-2.5 font-bold">Dipesan Oleh</th>
                                            <th class="px-4 py-2.5 font-bold text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($slots as $slot)
                                            <tr class="hover:bg-slate-50/70">
                                                <td class="px-4 py-3 font-bold text-slate-900">
                                                    {{ substr($slot->jam_mulai, 0, 5) }} WIB
                                                </td>
                                                <td class="px-4 py-3 font-bold text-slate-900">
                                                    {{ substr($slot->jam_selesai, 0, 5) }} WIB
                                                </td>
                                                <td class="px-4 py-3">
                                                    @if($slot->status_slot === 'tersedia')
                                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                            Tersedia
                                                        </span>
                                                    @else
                                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800 border border-rose-200">
                                                            Dibooking
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3">
                                                    @if($slot->booking && $slot->booking->customer)
                                                        <span class="font-bold text-slate-800">{{ $slot->booking->customer->nama }}</span>
                                                        <span class="block text-[10px] text-slate-400">#SPT-{{ str_pad($slot->booking->id_booking, 5, '0', STR_PAD_LEFT) }}</span>
                                                    @else
                                                        <span class="text-slate-400">-</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-right">
                                                    @if($slot->status_slot === 'tersedia')
                                                        <form action="{{ route('pemilik.slot.destroy', $slot->id_slot) }}" method="POST" onsubmit="return confirm('Hapus slot jam ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold p-1">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-slate-300 text-[10px] italic">Terkunci</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                </div>

                <!-- Right: Add New Slot Form -->
                <div class="lg:col-span-4 bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 space-y-5">
                    <div>
                        <span class="text-xs font-bold text-sport-600 uppercase tracking-wider block">TAMBAH JADWAL</span>
                        <h3 class="font-display font-extrabold text-lg text-slate-900">Buka Slot Jam Baru</h3>
                        <p class="text-xs text-slate-500 mt-1">Tambahkan jam operasional baru untuk disewa pelanggan.</p>
                    </div>

                    <form action="{{ route('pemilik.slot.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="id_lapangan" value="{{ $selectedLapanganId }}">
                        <input type="hidden" name="tanggal" value="{{ $selectedDate }}">

                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700">
                            <span class="block text-slate-500 text-[10px]">Untuk Lapangan:</span>
                            <span class="font-bold text-slate-900">{{ $myLapangans->find($selectedLapanganId)?->nama_lapangan }}</span>
                            <span class="block text-slate-500 text-[10px] mt-1">Tanggal:</span>
                            <span class="font-bold text-emerald-600">{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }}</span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Jam Mulai:</label>
                            <input type="time" name="jam_mulai" required value="08:00"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-sport-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Jam Selesai:</label>
                            <input type="time" name="jam_selesai" required value="09:00"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-sport-500">
                        </div>

                        <div class="p-3 rounded-xl bg-blue-50 border border-blue-200 text-blue-900 text-[11px] space-y-1">
                            <div class="flex items-center space-x-1.5 font-bold">
                                <i class="fa-solid fa-shield-check text-blue-600"></i>
                                <span>Pencegahan Jadwal Ganda</span>
                            </div>
                            <p class="text-blue-800 text-[10px]">
                                Sistem otomatis menolak input slot yang memiliki jam mulai bertabrakan pada lapangan dan tanggal yang sama.
                            </p>
                        </div>

                        <button type="submit" class="w-full py-3 px-4 rounded-xl bg-sport-600 hover:bg-sport-700 text-white font-bold text-xs shadow-md shadow-sport-600/30 transition">
                            <i class="fa-solid fa-plus mr-1"></i> Buka Slot Ini
                        </button>
                    </form>
                </div>

            </div>
        @endif

    </div>
</div>
@endsection
