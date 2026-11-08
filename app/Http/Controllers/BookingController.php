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
     * Menyimpan Booking dengan mekanisme Pessimistic Locking
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_customer' => 'required|exists:customer,id_customer',
            'id_slot'     => 'required|exists:slot,id_slot',
            'catatan'     => 'nullable|string|max:500',
        ]);

        $customerId = $request->id_customer;
        $slotId = $request->id_slot;

        try {
            $booking = DB::transaction(function () use ($customerId, $slotId, $request) {
                $slot = Slot::where('id_slot', $slotId)
                    ->lockForUpdate()
                    ->first();

                if (!$slot || $slot->status_slot !== 'tersedia') {
                    throw new \Exception('Maaf, slot sudah dipesan. Silakan pilih jam lain.');
                }

                $lapangan = Lapangan::findOrFail($slot->id_lapangan);

                $slot->status_slot = 'dibooking';
                $slot->save();

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
        $customerId = session('sportify_user_id');

        $bookings = Booking::with(['slot.lapangan'])
            ->where('id_customer', $customerId)
            ->orderBy('tanggal_booking', 'desc')
            ->get();

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

        if ($booking->status_booking !== 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan sudah diproses dan tidak dapat dibatalkan.'
            ], 400);
        }

        DB::transaction(function () use ($booking) {
            $booking->status_booking = 'cancelled';
            $booking->save();

            if ($booking->slot) {
                $booking->slot->status_slot = 'tersedia';
                $booking->slot->save();
            }
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Pesanan berhasil dibatalkan dan jadwal slot telah dibuka kembali.'
        ]);
    }
}
