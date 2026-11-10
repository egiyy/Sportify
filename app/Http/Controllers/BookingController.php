<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\Slot;
use App\Models\Lapangan;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Menyimpan booking dengan mekanisme Pessimistic Locking
     */
    public function store(Request $request)
    {
        // Pastikan pengguna sudah login sebagai customer
        if (
            session('sportify_user_role') !== 'customer' ||
            !session()->has('sportify_user_id')
        ) {
            return response()->json([
                'status' => 'error',
                'message' => 'Silakan login sebagai customer terlebih dahulu.'
            ], 401);
        }

        $request->validate([
            'id_slot' => 'required|exists:slot,id_slot',
            'catatan' => 'nullable|string|max:500',
        ]);

        // ID customer diambil dari session, bukan dari input form
        $customerId = session('sportify_user_id');
        $slotId = $request->id_slot;

        try {
            $booking = DB::transaction(function () use ($customerId, $slotId, $request) {
                $slot = Slot::where('id_slot', $slotId)
                    ->lockForUpdate()
                    ->first();

                if (!$slot || $slot->status_slot !== 'tersedia') {
                    throw new \Exception(
                        'Maaf, slot sudah dipesan. Silakan pilih jam lain.'
                    );
                }

                $lapangan = Lapangan::findOrFail($slot->id_lapangan);

                // Ubah status slot menjadi dibooking
                $slot->status_slot = 'dibooking';
                $slot->save();

                // Simpan data booking
                return Booking::create([
                    'id_customer' => $customerId,
                    'id_slot' => $slot->id_slot,
                    'id_admin' => $lapangan->id_admin,
                    'tanggal_booking' => Carbon::now(),
                    'total_harga' => $lapangan->harga_per_jam,
                    'status_booking' => 'pending',
                    'catatan' => $request->catatan,
                ]);
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Pemesanan lapangan berhasil dibuat!',
                'data' => $booking
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Menampilkan booking milik customer yang sedang login
     */

public function myBookings()
{
    if (session('sportify_user_role') !== 'customer') {
        return redirect()->route('login');
    }

    $customerId = session('sportify_user_id');

    $bookings = Booking::with(['slot.lapangan', 'pembayaran', 'ulasan'])
        ->where('id_customer', $customerId)
        ->orderBy('tanggal_booking', 'desc')
        ->paginate(5);

    return view('sportify.customer.my_bookings', compact('bookings'));
}


    /**
     * Menampilkan invoice booking
     */
    public function invoice($id)
    {
        $booking = Booking::with([
            'customer',
            'slot.lapangan.pemilik',
            'pembayaran'
        ])->findOrFail($id);

        return view('sportify.customer.invoice', compact('booking'));
    }

    /**
     * Pembatalan pemesanan
     */

public function cancel($id)
{
    $booking = Booking::with('slot')->findOrFail($id);

    // Pastikan booking milik customer yang sedang login
    if (
        session('sportify_user_role') !== 'customer' ||
        (int) $booking->id_customer !== (int) session('sportify_user_id')
    ) {
        return redirect()->route('customer.bookings')
            ->with('error', 'Anda tidak memiliki akses untuk membatalkan pesanan ini.');
    }

    if ($booking->status_booking !== 'pending') {
        return redirect()->route('customer.bookings')
            ->with('error', 'Pesanan sudah diproses dan tidak dapat dibatalkan.');
    }

    DB::transaction(function () use ($booking) {
        $booking->status_booking = 'cancelled';
        $booking->save();

        if ($booking->slot) {
            $booking->slot->status_slot = 'tersedia';
            $booking->slot->save();
        }
    });

    return redirect()->route('customer.bookings')
        ->with('success', 'Pesanan berhasil dibatalkan dan jadwal slot telah dibuka kembali.');
}

}
