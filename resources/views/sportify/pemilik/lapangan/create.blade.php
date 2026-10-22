@extends('sportify.layouts.app')

@section('title', 'Tambah Lapangan Baru - Sportify')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <a href="{{ route('pemilik.lapangan.index') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition mb-1 inline-block">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Daftar Lapangan
            </a>
            <h1 class="font-display font-extrabold text-2xl text-slate-900 tracking-tight">
                Tambah Lapangan Olahraga Baru
            </h1>
            <p class="text-xs text-slate-500">
                Lengkapi rincian venue lapangan untuk disewakan kepada pelanggan.
            </p>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xl p-6 sm:p-8">
            <form action="{{ route('pemilik.lapangan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lapangan:</label>
                    <input type="text" name="nama_lapangan" value="{{ old('nama_lapangan') }}" required placeholder="Contoh: Arena Futsal Sintetis Court A"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-sport-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Jenis Cabang Olahraga:</label>
                        <select name="jenis_olahraga" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sport-500">
                            <option value="Futsal">⚽ Futsal</option>
                            <option value="Badminton">🏸 Badminton</option>
                            <option value="Basket">🏀 Basket</option>
                            <option value="Voli">🏐 Bola Voli</option>
                            <option value="Mini Soccer">🥅 Mini Soccer</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Harga Sewa per Jam (Rp):</label>
                        <input type="number" name="harga_per_jam" value="{{ old('harga_per_jam', 120000) }}" min="10000" step="5000" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-sport-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Lengkap & Lokasi Lapangan:</label>
                    <textarea name="lokasi" rows="2" required placeholder="Contoh: Jl. ZA. Pagar Alam No. 45, Gedong Meneng, Rajabasa, Bandar Lampung"
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-sport-500">{{ old('lokasi') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Fasilitas Lapangan:</label>
                    <textarea name="deskripsi" rows="3" placeholder="Jelaskan jenis rumput/lantai, pencahayaan, ruang ganti, shower, mushola, dsb."
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-sport-500">{{ old('deskripsi') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Upload Foto Lapangan (Opsional):</label>
                    <input type="file" name="foto" accept="image/*"
                           class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sport-50 file:text-sport-700 hover:file:bg-sport-100">
                    <p class="text-[11px] text-slate-400 mt-1">Jika tidak diunggah, foto standar lapangan akan digunakan secara otomatis.</p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                    <a href="{{ route('pemilik.lapangan.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-bold text-xs hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-sport-600 hover:bg-sport-700 text-white font-bold text-xs shadow-md shadow-sport-600/30 transition">
                        Simpan & Buat Lapangan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
