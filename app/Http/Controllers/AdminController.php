<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\PemilikLapangan;
use App\Models\Lapangan;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\Reward;
use App\Models\Penukaran;
use App\Models\Point;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_customer' => Customer::count(),
            'total_pemilik' => PemilikLapangan::count(),
            'total_lapangan' => Lapangan::count(),
            'total_booking' => Booking::count(),
            'total_omset' => Booking::whereHas('pembayaran', fn($q) => $q->where('status_bayar', 'lunas'))->sum('total_harga'),
            'total_poin_beredar' => Point::sum('jumlah_point'),
            'total_penukaran' => Penukaran::count(),
        ];

        $recentBookings = Booking::with(['customer', 'slot.lapangan.pemilik', 'pembayaran'])
            ->latest('id_booking')
            ->take(8)
            ->get();

        $pendingLapangan = Lapangan::with('pemilik')
            ->where('status_verifikasi', 'pending')
            ->get();

        return view('sportify.admin.dashboard', compact('stats', 'recentBookings', 'pendingLapangan'));
    }

    // --- LAPANGAN MONITORING & VERIFICATION ---
    public function lapanganIndex()
    {
        $lapangans = Lapangan::with(['pemilik', 'admin'])->latest('id_lapangan')->paginate(12);
        return view('sportify.admin.lapangan', compact('lapangans'));
    }

    public function verifyLapangan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $lapangan = Lapangan::findOrFail($id);
        $lapangan->update([
            'status_verifikasi' => $request->status,
            'id_admin' => session('sportify_user_id'),
        ]);

        $statusText = $request->status === 'approved' ? 'disetujui' : 'ditolak';
        return back()->with('success', "Status lapangan '{$lapangan->nama_lapangan}' berhasil {$statusText}.");
    }

    // --- PEMILIK VERIFICATION ---
    public function pemilikIndex()
    {
        $pemiliks = PemilikLapangan::withCount('lapangan')->latest('id_pemilik')->paginate(15);
        return view('sportify.admin.pemilik', compact('pemiliks'));
    }

    public function verifyPemilik(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $pemilik = PemilikLapangan::findOrFail($id);
        $pemilik->update(['status_verifikasi' => $request->status]);

        $statusText = $request->status === 'approved' ? 'diverifikasi dan aktif' : 'dinonaktifkan / ditolak';
        return back()->with('success', "Akun pemilik '{$pemilik->nama_pemilik}' berhasil {$statusText}.");
    }

    // --- BOOKING & PEMBAYARAN MONITORING ---
    public function bookingIndex(Request $request)
    {
        $status = $request->query('status');

        $query = Booking::with(['customer', 'slot.lapangan.pemilik', 'pembayaran'])->latest('id_booking');

        if ($status && $status !== 'all') {
            $query->where('status_booking', $status);
        }

        $bookings = $query->paginate(15);

        return view('sportify.admin.bookings', compact('bookings', 'status'));
    }

    public function pembayaranIndex()
    {
        $pembayarans = Pembayaran::with(['booking.customer', 'booking.slot.lapangan'])->latest('id_pembayaran')->paginate(15);
        return view('sportify.admin.pembayaran', compact('pembayarans'));
    }

    // --- REWARDS CRUD ---
    public function rewardIndex()
    {
        $rewards = Reward::withCount('penukaran')->orderBy('poin_dibutuhkan')->get();
        $penukarans = Penukaran::with(['customer', 'reward'])->latest('id_penukaran')->take(15)->get();

        return view('sportify.admin.rewards', compact('rewards', 'penukarans'));
    }

    public function rewardStore(Request $request)
    {
        $request->validate([
            'nama_reward' => 'required|string|max:255',
            'poin_dibutuhkan' => 'required|integer|min:1',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'reward_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/rewards'), $filename);
            $fotoPath = '/uploads/rewards/' . $filename;
        } elseif ($request->filled('foto_url')) {
            $fotoPath = $request->foto_url;
        } else {
            $fotoPath = 'https://images.unsplash.com/photo-1560023907-5f339617ea30?w=600&auto=format&fit=crop&q=80';
        }

        Reward::create([
            'nama_reward' => $request->nama_reward,
            'poin_dibutuhkan' => $request->poin_dibutuhkan,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
        ]);

        return back()->with('success', 'Reward baru berhasil ditambahkan ke katalog!');
    }

    public function rewardUpdate(Request $request, $id)
    {
        $reward = Reward::findOrFail($id);

        $request->validate([
            'nama_reward' => 'required|string|max:255',
            'poin_dibutuhkan' => 'required|integer|min:1',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $reward->update([
            'nama_reward' => $request->nama_reward,
            'poin_dibutuhkan' => $request->poin_dibutuhkan,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('success', 'Data reward berhasil diperbarui.');
    }

    public function rewardDestroy($id)
    {
        $reward = Reward::findOrFail($id);
        $reward->delete();

        return back()->with('success', 'Reward berhasil dihapus dari sistem.');
    }
}
