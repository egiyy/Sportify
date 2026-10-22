@extends('sportify.layouts.app')

@section('title', 'Kelola Katalog Reward & Poin - Admin Sportify')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen" x-data="{ 
    addModal: false,
    editModal: false,
    editData: { id: '', nama: '', poin: '', stok: '', deskripsi: '' },
    openEdit(r) {
        this.editData = {
            id: r.id_reward,
            nama: r.nama_reward,
            poin: r.poin_dibutuhkan,
            stok: r.stok,
            deskripsi: r.deskripsi || ''
        };
        this.editModal = true;
    }
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition mb-1 inline-block">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Dashboard Admin
                </a>
                <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                    Katalog Hadiah & Program Loyalitas
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Kelola hadiah minuman, merchandise, atau voucher yang dapat ditukarkan pelanggan dengan poin.
                </p>
            </div>

            <button type="button" @click="addModal = true" class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold text-xs shadow-md shadow-amber-500/20 transition flex items-center">
                <i class="fa-solid fa-plus mr-1.5"></i> Tambah Hadiah Baru
            </button>
        </div>

        <!-- Rewards Grid Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($rewards as $r)
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="relative h-44 w-full bg-slate-100 overflow-hidden">
                            <img src="{{ $r->foto ?: 'https://images.unsplash.com/photo-1560023907-5f339617ea30?w=600' }}" class="w-full h-full object-cover">
                            <div class="absolute top-3 right-3">
                                <span class="px-2.5 py-1 rounded-xl text-xs font-extrabold bg-amber-400 text-slate-950 shadow-md">
                                    {{ $r->poin_dibutuhkan }} Poin
                                </span>
                            </div>
                            <div class="absolute bottom-3 left-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-dark-900/80 text-white">
                                    Stok: {{ $r->stok }} Unit
                                </span>
                            </div>
                        </div>

                        <div class="p-5 space-y-2">
                            <h3 class="font-display font-bold text-base text-slate-900">{{ $r->nama_reward }}</h3>
                            <p class="text-xs text-slate-500 line-clamp-2">{{ $r->deskripsi ?: 'Hadiah program loyalitas Sportify.' }}</p>
                            <span class="block text-[11px] text-purple-700 font-semibold pt-1">
                                <i class="fa-solid fa-gift mr-1"></i> Telah ditukar {{ $r->penukaran_count }} kali
                            </span>
                        </div>
                    </div>

                    <div class="p-5 pt-0 flex items-center justify-end space-x-2 border-t border-slate-100 mt-2">
                        <button type="button" @click="openEdit({{ json_encode($r) }})" class="px-3 py-1.5 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold text-xs transition">
                            <i class="fa-solid fa-pen mr-1"></i> Edit
                        </button>
                        <form action="{{ route('admin.reward.destroy', $r->id_reward) }}" method="POST" onsubmit="return confirm('Hapus hadiah ini dari katalog?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100 font-bold text-xs transition">
                                <i class="fa-solid fa-trash mr-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Redemptions List -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-8 space-y-4">
            <h3 class="font-display font-bold text-lg text-slate-900 pb-3 border-b border-slate-100 flex items-center justify-between">
                <span><i class="fa-solid fa-clock-rotate-left text-amber-500 mr-2"></i> Riwayat Penukaran Hadiah oleh Customer</span>
                <span class="text-xs text-slate-400 font-normal">Terbaru</span>
            </h3>

            @if($penukarans->isEmpty())
                <p class="text-xs text-slate-400 text-center py-6">Belum ada penukaran hadiah.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider text-[10px] border-b border-slate-100">
                            <tr>
                                <th class="px-4 py-2.5 font-bold">ID</th>
                                <th class="px-4 py-2.5 font-bold">Customer</th>
                                <th class="px-4 py-2.5 font-bold">Hadiah yang Ditukar</th>
                                <th class="px-4 py-2.5 font-bold">Poin Ditebus</th>
                                <th class="px-4 py-2.5 font-bold">Waktu Klaim</th>
                                <th class="px-4 py-2.5 font-bold text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($penukarans as $tukar)
                                <tr class="hover:bg-slate-50/70">
                                    <td class="px-4 py-3 font-mono font-bold text-slate-900">#TK-{{ $tukar->id_penukaran }}</td>
                                    <td class="px-4 py-3 font-bold text-slate-800">{{ $tukar->customer->nama ?? 'Customer' }}</td>
                                    <td class="px-4 py-3 font-semibold text-slate-800">{{ $tukar->reward->nama_reward }}</td>
                                    <td class="px-4 py-3 font-extrabold text-amber-600">-{{ $tukar->reward->poin_dibutuhkan }} Poin</td>
                                    <td class="px-4 py-3 text-slate-500">{{ $tukar->tanggal_tukar->translatedFormat('d M Y, H:i') }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800">
                                            {{ ucfirst($tukar->status_penukaran) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

    <!-- Modal Add Reward -->
    <div x-show="addModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 text-center">
            <div @click="addModal = false" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm"></div>
            <div class="inline-block bg-white rounded-3xl p-6 text-left overflow-hidden shadow-2xl max-w-md w-full relative z-10 border border-slate-100">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                    <h3 class="font-display font-bold text-base text-slate-900">Tambah Hadiah Baru</h3>
                    <button @click="addModal = false" class="text-slate-400 hover:text-slate-700">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form action="{{ route('admin.reward.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Hadiah:</label>
                        <input type="text" name="nama_reward" required placeholder="Contoh: Jersey Sportify Edisi Terbatas"
                               class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-purple-500 focus:outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Poin Dibutuhkan:</label>
                            <input type="number" name="poin_dibutuhkan" required min="1" value="100"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-purple-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Jumlah Stok:</label>
                            <input type="number" name="stok" required min="1" value="20"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-purple-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Hadiah:</label>
                        <textarea name="deskripsi" rows="2" placeholder="Keterangan singkat hadiah..."
                                  class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-purple-500 focus:outline-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Foto Hadiah (Opsional):</label>
                        <input type="file" name="foto" accept="image/*" class="text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-slate-100 file:text-xs">
                    </div>

                    <div class="pt-2 flex justify-end space-x-2">
                        <button type="button" @click="addModal = false" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-700">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-xs shadow-md">Simpan Hadiah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Reward -->
    <div x-show="editModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 text-center">
            <div @click="editModal = false" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm"></div>
            <div class="inline-block bg-white rounded-3xl p-6 text-left overflow-hidden shadow-2xl max-w-md w-full relative z-10 border border-slate-100">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                    <h3 class="font-display font-bold text-base text-slate-900">Perbarui Hadiah</h3>
                    <button @click="editModal = false" class="text-slate-400 hover:text-slate-700">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form :action="'{{ url('admin/rewards') }}/' + editData.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Hadiah:</label>
                        <input type="text" name="nama_reward" x-model="editData.nama" required
                               class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-purple-500 focus:outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Poin Dibutuhkan:</label>
                            <input type="number" name="poin_dibutuhkan" x-model="editData.poin" required min="1"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-purple-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Jumlah Stok:</label>
                            <input type="number" name="stok" x-model="editData.stok" required min="0"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-purple-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Hadiah:</label>
                        <textarea name="deskripsi" rows="2" x-model="editData.deskripsi"
                                  class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-purple-500 focus:outline-none"></textarea>
                    </div>

                    <div class="pt-2 flex justify-end space-x-2">
                        <button type="button" @click="editModal = false" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-700">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs shadow-md">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
