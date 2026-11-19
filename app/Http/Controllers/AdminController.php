<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\PemilikLapangan;
use App\Models\Lapangan;
use App\Models\Booking;
use App\Models\Pembayaran;

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
        ];

        $recentBookings = Booking::with(['customer', 'slot.lapangan.pemilik', 'pembayaran'])
            ->latest('id_booking')
            ->take(8)
            ->get();

        $pendingLapangan = Lapangan::with('pemilik')
            ->where('status_verifikasi', 'pending')
            ->get();

        $pendingPemilik = PemilikLapangan::where('status_verifikasi', 'pending')
            ->get();

        return view('sportify.admin.dashboard', compact('stats', 'recentBookings', 'pendingLapangan', 'pendingPemilik'));
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
}
