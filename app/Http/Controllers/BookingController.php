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
    public function store(Request $request)
    {
        if (!session()->has('sportify_user_id') || session('sportify_user_role') !== 'customer') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Pelanggan (Customer) untuk melakukan pemesanan.');
        }

        $request->validate([
            'id_slot' => 'required|exists:slot,id_slot',
            'catatan' => 'nullable|string|max:500',
        ]);

        $customerId = session('sportify_user_id');
        $slotId = $request->id_slot;

        try {
            $booking = DB::transaction(function () use ($customerId, $slotId, $request) {
                // Lock the slot record to prevent race conditions & double booking
                $slot = Slot::where('id_slot', $slotId)->lockForUpdate()->first();

                if ($slot->status_slot !== 'tersedia') {
                    throw new \Exception('Maaf, slot jadwal ini baru saja dipesan oleh orang lain. Silakan pilih slot jam lain.');
                }

                $lapangan = Lapangan::findOrFail($slot->id_lapangan);

                // Update slot status to dibooking
                $slot->status_slot = 'dibooking';
                $slot->save();

                // Create booking
                $newBooking = Booking::create([
                    'id_customer' => $customerId,
                    'id_slot' => $slot->id_slot,
                    'id_admin' => $lapangan->id_admin,
                    'tanggal_booking' => Carbon::now(),
                    'total_harga' => $lapangan->harga_per_jam,
                    'status_booking' => 'pending',
                    'catatan' => $request->catatan,
                ]);

                return $newBooking;
            });

            return redirect()->route('pembayaran.show', $booking->id_booking)
                ->with('success', 'Pemesanan berhasil dibuat! Segera selesaikan pembayaran dan unggah bukti transfer.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function myBookings(Request $request)
    {
        $customerId = session('sportify_user_id');

        $status = $request->query('status');

        $query = Booking::with(['slot.lapangan.pemilik', 'pembayaran', 'ulasan'])
            ->where('id_customer', $customerId)
            ->latest('id_booking');

        if ($status && $status !== 'all') {
            $query->where('status_booking', $status);
        }

        $bookings = $query->paginate(10);

        return view('sportify.customer.my_bookings', compact('bookings', 'status'));
    }

    public function cancel($id)
    {
        $customerId = session('sportify_user_id');
        $booking = Booking::with('slot')->where('id_customer', $customerId)->findOrFail($id);

        if ($booking->status_booking !== 'pending') {
            return back()->with('error', 'Pesanan ini sudah diproses dan tidak dapat dibatalkan.');
        }

        DB::transaction(function () use ($booking) {
            $booking->status_booking = 'cancelled';
            $booking->save();

            // Release the slot back to tersedia
            if ($booking->slot) {
                $booking->slot->status_slot = 'tersedia';
                $booking->slot->save();
            }
        });

        return back()->with('success', 'Pemesanan berhasil dibatalkan dan slot jadwal telah dibuka kembali.');
    }
}
