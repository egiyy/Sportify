@extends('sportify.layouts.app')

@section('title', 'Tentang SPORTIFY & Tim Pengembang UNILA')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header Section -->
        <div class="text-center max-w-3xl mx-auto space-y-4">
            <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold">
                <i class="fa-solid fa-graduation-cap text-emerald-600"></i>
                <span>Mata Kuliah Pemrograman Web Lanjut</span>
            </div>
            <h1 class="font-display font-extrabold text-3xl sm:text-5xl text-slate-900 tracking-tight">
                SPORTIFY & Tim Pengembang
            </h1>
            <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                Sistem Pemesanan Lapangan Futsal & Olahraga berbasis web yang menghubungkan Admin, Pemilik Lapangan, dan Pelanggan dengan database terpusat PostgreSQL dan arsitektur anti-double booking.
            </p>
        </div>

        <!-- Academic Team Cards (Per Proposal Cover Page 1) -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xl p-8 sm:p-10 space-y-6">
            <div class="text-center max-w-xl mx-auto mb-6">
                <span class="text-xs font-bold text-sport-600 uppercase tracking-widest block">PROFIL ANGGOTA KELOMPOK</span>
                <h2 class="font-display font-extrabold text-2xl text-slate-900 mt-1">
                    Jurusan Ilmu Komputer - FMIPA UNILA
                </h2>
                <p class="text-xs text-slate-500 mt-1">Universitas Lampung</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Member 1: Reggy Desvita Kamal -->
                <div class="p-6 rounded-3xl bg-gradient-to-b from-slate-50 to-emerald-50/50 border border-emerald-100 text-center space-y-3 hover:shadow-lg transition">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-sport-600 to-sport-400 text-white flex items-center justify-center font-bold text-xl mx-auto shadow-md shadow-sport-500/20">
                        RD
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">Reggy Desvita Kamal</h3>
                        <p class="font-mono text-xs font-extrabold text-emerald-700 bg-emerald-100/80 px-2.5 py-0.5 rounded-full inline-block mt-1">
                            2417051016
                        </p>
                    </div>
                    <p class="text-[11px] text-slate-500">Lead Developer & Database Architect</p>
                </div>

                <!-- Member 2: Elsy Aliffia Sirony Putri -->
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 text-center space-y-3 hover:shadow-lg transition">
                    <div class="w-16 h-16 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-bold text-xl mx-auto shadow-md shadow-blue-500/20">
                        EA
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">Elsy Aliffia Sirony Putri</h3>
                        <p class="font-mono text-xs font-bold text-blue-700 bg-blue-100 px-2.5 py-0.5 rounded-full inline-block mt-1">
                            2417051025
                        </p>
                    </div>
                    <p class="text-[11px] text-slate-500">UI/UX Designer & System Analyst</p>
                </div>

                <!-- Member 3: Nur Ramadhani -->
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 text-center space-y-3 hover:shadow-lg transition">
                    <div class="w-16 h-16 rounded-2xl bg-purple-600 text-white flex items-center justify-center font-bold text-xl mx-auto shadow-md shadow-purple-500/20">
                        NR
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">Nur Ramadhani</h3>
                        <p class="font-mono text-xs font-bold text-purple-700 bg-purple-100 px-2.5 py-0.5 rounded-full inline-block mt-1">
                            2417051067
                        </p>
                    </div>
                    <p class="text-[11px] text-slate-500">Backend & Flow Implementation</p>
                </div>

                <!-- Member 4: Muhammad Rafi Al Musthafa -->
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 text-center space-y-3 hover:shadow-lg transition">
                    <div class="w-16 h-16 rounded-2xl bg-amber-600 text-white flex items-center justify-center font-bold text-xl mx-auto shadow-md shadow-amber-500/20">
                        MR
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">Muhammad Rafi Al Musthafa</h3>
                        <p class="font-mono text-xs font-bold text-amber-700 bg-amber-100 px-2.5 py-0.5 rounded-full inline-block mt-1">
                            2457051009
                        </p>
                    </div>
                    <p class="text-[11px] text-slate-500">Quality Assurance & Data Modeling</p>
                </div>

            </div>
        </div>

        <!-- Tech Stack & Architecture (Per Bab III 3.1) -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-8 sm:p-10 space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-sport-100 text-sport-700 flex items-center justify-center font-bold text-lg">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div>
                    <h2 class="font-display font-extrabold text-xl text-slate-900">Spesifikasi Teknologi Sistem (Bab III.1)</h2>
                    <p class="text-xs text-slate-500">Kombinasi teknologi mutakhir untuk performa cepat dan keandalan data</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                    <div class="flex items-center space-x-2 text-rose-600 font-bold text-sm">
                        <i class="fa-brands fa-laravel text-xl"></i>
                        <span>Framework Laravel 12</span>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Arsitektur MVC tangguh dengan Eloquent ORM, middleware otorisasi multi-peran, dan session authentication.
                    </p>
                </div>

                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                    <div class="flex items-center space-x-2 text-blue-600 font-bold text-sm">
                        <i class="fa-solid fa-database text-xl"></i>
                        <span>Basis Data PostgreSQL 14</span>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Database relasional kelas enterprise dengan dukungan locking transaksi (ACID) dan foreign key cascade constraint.
                    </p>
                </div>

                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                    <div class="flex items-center space-x-2 text-teal-600 font-bold text-sm">
                        <i class="fa-solid fa-palette text-xl"></i>
                        <span>Tailwind CSS & Alpine.js</span>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Desain responsif modern, tipografi sporty yang elegan, transisi mulus, dan komponen interaktif tanpa lag.
                    </p>
                </div>
            </div>
        </div>

        <!-- 10 Entities Database Architecture (Per Bab III 3.2 & 3.3) -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-8 sm:p-10 space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-sitemap"></i>
                    </div>
                    <div>
                        <h2 class="font-display font-extrabold text-xl text-slate-900">Perancangan Basis Data 10 Entitas (ERD)</h2>
                        <p class="text-xs text-slate-500">Struktur relasi tabel sesuai Bab III dokumen perancangan</p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800">
                    10 Tabel Sesuai Laporan
                </span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <span class="font-mono text-xs font-bold text-slate-900 block">1. admin</span>
                    <span class="text-[10px] text-slate-500">PK: id_admin</span>
                </div>
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <span class="font-mono text-xs font-bold text-slate-900 block">2. customer</span>
                    <span class="text-[10px] text-slate-500">PK: id_customer</span>
                </div>
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <span class="font-mono text-xs font-bold text-slate-900 block">3. pemilik_lapangan</span>
                    <span class="text-[10px] text-slate-500">PK: id_pemilik</span>
                </div>
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <span class="font-mono text-xs font-bold text-slate-900 block">4. lapangan</span>
                    <span class="text-[10px] text-slate-500">PK: id_lapangan</span>
                </div>
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <span class="font-mono text-xs font-bold text-slate-900 block">5. slot</span>
                    <span class="text-[10px] text-slate-500">PK: id_slot</span>
                </div>
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <span class="font-mono text-xs font-bold text-slate-900 block">6. booking</span>
                    <span class="text-[10px] text-slate-500">PK: id_booking</span>
                </div>
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <span class="font-mono text-xs font-bold text-slate-900 block">7. pembayaran</span>
                    <span class="text-[10px] text-slate-500">PK: id_pembayaran</span>
                </div>
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <span class="font-mono text-xs font-bold text-slate-900 block">8. point</span>
                    <span class="text-[10px] text-slate-500">PK: id_point</span>
                </div>
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <span class="font-mono text-xs font-bold text-slate-900 block">9. reward</span>
                    <span class="text-[10px] text-slate-500">PK: id_reward</span>
                </div>
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <span class="font-mono text-xs font-bold text-slate-900 block">10. penukaran</span>
                    <span class="text-[10px] text-slate-500">PK: id_penukaran</span>
                </div>
            </div>

            <!-- Problem Solution Box -->
            <div class="p-5 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-950 space-y-2">
                <h4 class="font-bold text-emerald-900 flex items-center">
                    <i class="fa-solid fa-shield-halved text-emerald-600 mr-2"></i> Solusi Rumusan Masalah 3: Pencegahan Jadwal Ganda (Double Booking)
                </h4>
                <p class="leading-relaxed">
                    Sesuai dengan <strong>Rumusan Masalah 3</strong> dan <strong>Tujuan 3</strong> dalam dokumen perancangan, mekanisme pencegahan pemesanan ganda diimplementasikan pada dua lapisan:
                </p>
                <ol class="list-decimal list-inside space-y-1 pl-2">
                    <li><strong>Batasan Basis Data (Constraint):</strong> Constraint unik gabungan <code>UNIQUE(id_lapangan, tanggal, jam_mulai)</code> pada tabel <code>slot</code> menjamin database menolak jadwal ganda pada tingkat fisik.</li>
                    <li><strong>Pencegahan Konkurensi (Pessimistic Locking):</strong> Eksekusi transaksi Laravel dengan <code>lockForUpdate()</code> saat customer memesan slot, mencegah race condition saat dua pelanggan memesan slot yang sama bersamaan.</li>
                </ol>
            </div>
        </div>

    </div>
</div>
@endsection
