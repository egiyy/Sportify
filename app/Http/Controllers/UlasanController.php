<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Ulasan;
use Carbon\Carbon;

class UlasanController extends Controller
{
    public function store(Request $request)
    {
        $customerId = session('sportify_user_id');

        $request->validate([
            'id_booking' => 'required|exists:booking,id_booking',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
        ]);

        $booking = Booking::with('slot')->where('id_customer', $customerId)->findOrFail($request->id_booking);

        if ($booking->status_booking !== 'completed') {
            return back()->with('error', 'Anda hanya dapat memberikan ulasan pada pesanan yang sudah selesai dimainkan.');
        }

        if ($booking->ulasan) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        $ulasan = Ulasan::create([
            'id_booking' => $booking->id_booking,
            'id_customer' => $customerId,
            'id_lapangan' => $booking->slot->id_lapangan,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Terima kasih atas ulasan dan penilaian yang Anda berikan!');
    }

    public function reply(Request $request, $id)
    {
        $pemilikId = session('sportify_user_id');

        $request->validate([
            'balasan_pemilik' => 'required|string|max:1000',
        ]);

        $ulasan = Ulasan::with('lapangan')->findOrFail($id);

        if ($ulasan->lapangan->id_pemilik != $pemilikId) {
            return back()->with('error', 'Anda tidak berwenang membalas ulasan pada lapangan ini.');
        }

        $ulasan->update([
            'balasan_pemilik' => $request->balasan_pemilik,
            'tanggal_balasan' => Carbon::now(),
        ]);

        return back()->with('success', 'Balasan ulasan berhasil dikirim ke pelanggan.');
    }
}
