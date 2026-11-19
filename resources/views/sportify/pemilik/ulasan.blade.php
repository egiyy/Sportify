@extends('sportify.layouts.app')

@section('title', 'Ulasan Lapangan - Pemilik Lapangan Sportify')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen" x-data="{
    replyModal: false,
    replyData: { id: '', nama: '', komentar: '', balasan: '' },
    openReply(u) {
        this.replyData = {
            id: u.id_ulasan,
            nama: u.customer ? u.customer.nama : 'Pelanggan',
            komentar: u.komentar,
            balasan: u.balasan_pemilik || ''
        };
        this.replyModal = true;
    }
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('pemilik.dashboard') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition mb-1 inline-block">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Dashboard Pemilik
                </a>
                <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-900 tracking-tight">
                    Ulasan & Penilaian Pelanggan
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Pantau ulasan dari pelanggan yang telah selesai bermain di lapangan Anda dan berikan balasan.
                </p>
            </div>
        </div>

        <!-- Reviews List -->
        <div class="space-y-4">
            @forelse($ulasans as $ulasan)
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-2xl bg-sport-100 text-sport-700 font-extrabold flex items-center justify-center text-sm">
                                {{ strtoupper(substr($ulasan->customer->nama ?? 'P', 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">{{ $ulasan->customer->nama ?? 'Pelanggan' }}</h4>
                                <span class="text-[11px] text-slate-400 font-medium">
                                    Lapangan: <strong class="text-slate-700">{{ $ulasan->lapangan->nama_lapangan ?? 'Lapangan' }}</strong> &bull; 
                                    {{ $ulasan->created_at->translatedFormat('d F Y, H:i') }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <div class="flex items-center text-amber-400 text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= $ulasan->rating ? 'text-amber-400' : 'text-slate-200' }}"></i>
                                @endfor
                                <span class="ml-1.5 font-bold text-slate-700 text-xs">{{ $ulasan->rating }}.0</span>
                            </div>

                            <button type="button" @click="openReply({{ json_encode($ulasan) }})" class="px-3.5 py-1.5 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold text-xs transition">
                                <i class="fa-solid fa-reply mr-1"></i> {{ $ulasan->balasan_pemilik ? 'Ubah Balasan' : 'Balas Ulasan' }}
                            </button>
                        </div>
                    </div>

                    <p class="text-xs text-slate-700 leading-relaxed italic">
                        "{{ $ulasan->komentar }}"
                    </p>

                    @if($ulasan->balasan_pemilik)
                        <div class="p-4 rounded-2xl bg-blue-50/70 border border-blue-100 text-xs space-y-1">
                            <div class="flex items-center justify-between text-blue-900 font-bold text-[11px]">
                                <span class="flex items-center">
                                    <i class="fa-solid fa-reply fa-rotate-180 mr-1.5 text-blue-500"></i> Balasan Anda:
                                </span>
                                @if($ulasan->tanggal_balasan)
                                    <span class="text-[10px] text-blue-600 font-normal">
                                        {{ \Carbon\Carbon::parse($ulasan->tanggal_balasan)->translatedFormat('d M Y, H:i') }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-slate-700">
                                {{ $ulasan->balasan_pemilik }}
                            </p>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center text-slate-400 space-y-2">
                    <i class="fa-solid fa-comments text-4xl text-slate-300"></i>
                    <h4 class="font-bold text-slate-700 text-sm">Belum Ada Ulasan</h4>
                    <p class="text-xs">Ulasan akan muncul di sini setelah pelanggan menyelesaikan jadwal bermain.</p>
                </div>
            @endforelse
        </div>

        @if($ulasans->hasPages())
            <div class="pt-4">
                {{ $ulasans->links() }}
            </div>
        @endif

    </div>

    <!-- Modal Balas Ulasan -->
    <div x-show="replyModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 text-center">
            <div @click="replyModal = false" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm"></div>
            <div class="inline-block bg-white rounded-3xl p-6 text-left overflow-hidden shadow-2xl max-w-md w-full relative z-10 border border-slate-100 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-display font-bold text-base text-slate-900">Kirim Balasan Ulasan</h3>
                    <button @click="replyModal = false" class="text-slate-400 hover:text-slate-700">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-xs">
                    <span class="text-slate-400 font-bold block mb-0.5">Ulasan dari <span x-text="replyData.nama"></span>:</span>
                    <p class="text-slate-700 italic" x-text="replyData.komentar"></p>
                </div>

                <form :action="'{{ url('pemilik/ulasan') }}/' + replyData.id + '/reply'" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tulis Balasan Anda:</label>
                        <textarea name="balasan_pemilik" rows="4" required x-model="replyData.balasan" placeholder="Terima kasih atas kunjungannya, kami tunggu kedatangannya kembali!..."
                                  class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                    </div>

                    <div class="flex justify-end space-x-2 pt-2">
                        <button type="button" @click="replyModal = false" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md">
                            Kirim Balasan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
