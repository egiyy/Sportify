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
     * Menyimpan Booking dengan Mekanisme Pessimistic Locking (Mencegah Double Booking)
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_customer' => 'required|exists:customer,id_customer',
            'id_slot'     => 'required|exists:slot,id_slot',
            'catatan'     => 'nullable|string|max:500',
        ]);

        $customerId = $request->id_customer;
        $slotId     = $request->id_slot;

        try {
            // Eksekusi transaksi atomik
            $booking = DB::transaction(function () use ($customerId, $slotId, $request) {
                
                // 1. Kunci baris slot di database PostgreSQL agar tidak bisa diakses proses lain bersamaan
                $slot = Slot::where('id_slot', $slotId)->lockForUpdate()->first();

                // 2. Validasi apakah slot masih berstatus 'tersedia'
                if ($slot->status_slot !== 'tersedia') {
                    throw new \Exception('Maaf, slot jadwal jam ini baru saja dipesan orang lain! Silakan pilih jam lain.');
                }

                $lapangan = Lapangan::findOrFail($slot->id_lapangan);

                // 3. Kunci status slot menjadi 'dibooking'
                $slot->status_slot = 'dibooking';
                $slot->save();

                // 4. Buat record pemesanan
                $newBooking = Booking::create([
                    'id_customer'     => $customerId,
                    'id_slot'         => $slot->id_slot,
                    'id_admin'        => $lapangan->id_admin,
                    'tanggal_booking' => Carbon::now(),
                    'total_harga'     => $lapangan->harga_per_jam,
                    'status_booking'  => 'pending',
                    'catatan'         => $request->catatan,
                ]);

                return $newBooking;
            });

            return response()->json([
                'status'  => 'success',
                'message' => 'Pemesanan lapangan berhasil dibuat!',
                'data'    => $booking
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Pembatalan Pemesanan (Pelepasan Slot Kembali Tersedia)
     */
    public function cancel($id)
    {
        $booking = Booking::with('slot')->findOrFail($id);

        if ($booking->status_booking !== 'pending') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Pesanan sudah diproses dan tidak dapat dibatalkan.'
            ], 400);
        }

        DB::transaction(function () use ($booking) {
            $booking->status_booking = 'cancelled';
            $booking->save();

            // Kembalikan slot menjadi 'tersedia' untuk pelanggan lain
            if ($booking->slot) {
                $booking->slot->status_slot = 'tersedia';
                $booking->slot->save();
            }
        });

        return response()->json([
            'status'  => 'success',
            'message' => 'Pesanan berhasil dibatalkan dan jadwal slot telah dibuka kembali.'
        ]);
    }
}