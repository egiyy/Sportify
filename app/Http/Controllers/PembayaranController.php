<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Pembayaran;
use Carbon\Carbon;

class PembayaranController extends Controller
{
    public function show($id)
    {
        $customerId = session('sportify_user_id');
        $booking = Booking::with(['slot.lapangan.pemilik', 'pembayaran'])
            ->where('id_customer', $customerId)
            ->findOrFail($id);

        return view('sportify.customer.pembayaran', compact('booking'));
    }

    public function store(Request $request, $id)
    {
        $customerId = session('sportify_user_id');
        $booking = Booking::where('id_customer', $customerId)->findOrFail($id);

        $request->validate([
            'metode_bayar' => 'required|string',
            'bukti_bayar' => 'required|file|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $filePath = null;
        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $filename = 'bukti_' . $booking->id_booking . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/bukti_bayar'), $filename);
            $filePath = '/uploads/bukti_bayar/' . $filename;
        }

        Pembayaran::updateOrCreate(
            ['id_booking' => $booking->id_booking],
            [
                'metode_bayar' => $request->metode_bayar,
                'status_bayar' => 'pending',
                'waktu_transaksi' => Carbon::now(),
                'bukti_bayar' => $filePath,
                'catatan_verifikasi' => 'Bukti pembayaran telah diunggah. Menunggu verifikasi pemilik lapangan.',
            ]
        );

        return redirect()->route('customer.bookings')
            ->with('success', 'Bukti pembayaran berhasil diunggah! Pemilik lapangan akan segera memverifikasi pesanan Anda.');
    }

    public function invoice($id)
    {
        $customerId = session('sportify_user_id');
        $userRole = session('sportify_user_role');

        $query = Booking::with(['slot.lapangan.pemilik', 'customer', 'pembayaran']);

        // Check authorization
        if ($userRole === 'customer') {
            $query->where('id_customer', $customerId);
        }

        $booking = $query->findOrFail($id);

        return view('sportify.customer.invoice', compact('booking'));
    }
}
