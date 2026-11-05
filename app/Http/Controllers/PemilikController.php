<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PemilikLapangan;
use App\Models\Lapangan;
use App\Models\Slot;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\Point;
use App\Models\Ulasan;
use Carbon\Carbon;

class PemilikController extends Controller
{
    private function getPemilikId()
    {
        return session('sportify_user_id');
    }

    public function dashboard()
    {
        $pemilikId = $this->getPemilikId();
        $lapanganIds = Lapangan::where('id_pemilik', $pemilikId)->pluck('id_lapangan');

        $totalLapangan = $lapanganIds->count();

        $bookingQuery = Booking::whereHas('slot', function ($q) use ($lapanganIds) {
            $q->whereIn('id_lapangan', $lapanganIds);
        });

        $totalBooking = (clone $bookingQuery)->count();
        $pendingBooking = (clone $bookingQuery)->where('status_booking', 'pending')->count();
        $confirmedBooking = (clone $bookingQuery)->whereIn('status_booking', ['confirmed', 'completed'])->count();

        $totalPendapatan = (clone $bookingQuery)
            ->whereHas('pembayaran', function ($q) {
                $q->where('status_bayar', 'lunas');
            })
            ->sum('total_harga');

        $recentBookings = (clone $bookingQuery)
            ->with(['customer', 'slot.lapangan', 'pembayaran'])
            ->latest('id_booking')
            ->take(6)
            ->get();

        return view('sportify.pemilik.dashboard', compact(
            'totalLapangan',
            'totalBooking',
            'pendingBooking',
            'confirmedBooking',
            'totalPendapatan',
            'recentBookings'
        ));
    }

    // --- LAPANGAN CRUD ---
    public function lapanganIndex()
    {
        $pemilikId = $this->getPemilikId();
        $lapangans = Lapangan::withCount('slots')
            ->where('id_pemilik', $pemilikId)
            ->latest('id_lapangan')
            ->get();

        return view('sportify.pemilik.lapangan.index', compact('lapangans'));
    }

    public function lapanganCreate()
    {
        return view('sportify.pemilik.lapangan.create');
    }

    public function lapanganStore(Request $request)
    {
        $pemilikId = $this->getPemilikId();

        $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'jenis_olahraga' => 'required|string|max:50',
            'lokasi' => 'required|string',
            'harga_per_jam' => 'required|numeric|min:10000',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'lapangan_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/lapangan'), $filename);
            $fotoPath = '/uploads/lapangan/' . $filename;
        } elseif ($request->filled('foto_url')) {
            $fotoPath = $request->foto_url;
        } else {
            $fotoPath = 'https://images.unsplash.com/photo-1529900748604-07564a03e7a6?w=800&auto=format&fit=crop&q=80';
        }

        $lapangan = Lapangan::create([
            'id_pemilik' => $pemilikId,
            'nama_lapangan' => $request->nama_lapangan,
            'jenis_olahraga' => $request->jenis_olahraga,
            'lokasi' => $request->lokasi,
            'harga_per_jam' => $request->harga_per_jam,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
            'status_verifikasi' => 'approved', // Auto-approved or pending by admin
        ]);

        // Auto-generate slots for today and next 2 days
        $timeSlots = [
            ['08:00', '09:00'],
            ['09:00', '10:00'],
            ['14:00', '15:00'],
            ['15:00', '16:00'],
            ['16:00', '17:00'],
            ['18:00', '19:00'],
            ['19:00', '20:00'],
            ['20:00', '21:00'],
        ];

        for ($day = 0; $day <= 2; $day++) {
            $date = Carbon::today()->addDays($day)->toDateString();
            foreach ($timeSlots as $slotTime) {
                Slot::firstOrCreate(
                    [
                        'id_lapangan' => $lapangan->id_lapangan,
                        'tanggal' => $date,
                        'jam_mulai' => $slotTime[0],
                    ],
                    [
                        'jam_selesai' => $slotTime[1],
                        'status_slot' => 'tersedia',
                    ]
                );
            }
        }

        return redirect()->route('pemilik.lapangan.index')->with('success', 'Lapangan baru berhasil didaftarkan dan slot jadwal telah siap!');
    }

    public function lapanganEdit($id)
    {
        $pemilikId = $this->getPemilikId();
        $lapangan = Lapangan::where('id_pemilik', $pemilikId)->findOrFail($id);

        return view('sportify.pemilik.lapangan.edit', compact('lapangan'));
    }

    public function lapanganUpdate(Request $request, $id)
    {
        $pemilikId = $this->getPemilikId();
        $lapangan = Lapangan::where('id_pemilik', $pemilikId)->findOrFail($id);

        $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'jenis_olahraga' => 'required|string|max:50',
            'lokasi' => 'required|string',
            'harga_per_jam' => 'required|numeric|min:10000',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $data = [
            'nama_lapangan' => $request->nama_lapangan,
            'jenis_olahraga' => $request->jenis_olahraga,
            'lokasi' => $request->lokasi,
            'harga_per_jam' => $request->harga_per_jam,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'lapangan_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/lapangan'), $filename);
            $data['foto'] = '/uploads/lapangan/' . $filename;
        }

        $lapangan->update($data);

        return redirect()->route('pemilik.lapangan.index')->with('success', 'Data lapangan berhasil diperbarui.');
    }

    public function lapanganDestroy($id)
    {
        $pemilikId = $this->getPemilikId();
        $lapangan = Lapangan::where('id_pemilik', $pemilikId)->findOrFail($id);
        $lapangan->delete();

        return redirect()->route('pemilik.lapangan.index')->with('success', 'Lapangan berhasil dihapus.');
    }

    // --- SLOTS MANAGEMENT ---
    public function slotIndex(Request $request)
    {
        $pemilikId = $this->getPemilikId();
        $myLapangans = Lapangan::where('id_pemilik', $pemilikId)->get();

        $selectedLapanganId = $request->query('id_lapangan', $myLapangans->first()?->id_lapangan);
        $selectedDate = $request->query('tanggal', Carbon::today()->toDateString());

        $slots = Slot::with('booking.customer')
            ->where('id_lapangan', $selectedLapanganId)
            ->where('tanggal', $selectedDate)
            ->orderBy('jam_mulai')
            ->get();

        return view('sportify.pemilik.slots', compact('myLapangans', 'selectedLapanganId', 'selectedDate', 'slots'));
    }

    public function slotStore(Request $request)
    {
        $request->validate([
            'id_lapangan' => 'required|exists:lapangan,id_lapangan',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        try {
            Slot::create([
                'id_lapangan' => $request->id_lapangan,
                'tanggal' => $request->tanggal,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'status_slot' => 'tersedia',
            ]);

            return back()->with('success', 'Slot jadwal baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan slot: Jadwal pada jam tersebut sudah ada (mencegah jadwal ganda).');
        }
    }

    public function slotDestroy($id)
    {
        $slot = Slot::findOrFail($id);
        if ($slot->status_slot === 'dibooking') {
            return back()->with('error', 'Slot yang sudah dibooking tidak dapat dihapus.');
        }

        $slot->delete();
        return back()->with('success', 'Slot jadwal berhasil dihapus.');
    }

    // --- BOOKING & PAYMENT MANAGEMENT ---
    public function bookingIndex(Request $request)
    {
        $pemilikId = $this->getPemilikId();
        $lapanganIds = Lapangan::where('id_pemilik', $pemilikId)->pluck('id_lapangan');

        $status = $request->query('status');

        $query = Booking::with(['customer', 'slot.lapangan', 'pembayaran'])
            ->whereHas('slot', function ($q) use ($lapanganIds) {
                $q->whereIn('id_lapangan', $lapanganIds);
            })
            ->latest('id_booking');

        if ($status && $status !== 'all') {
            $query->where('status_booking', $status);
        }

        $bookings = $query->paginate(12);

        return view('sportify.pemilik.bookings', compact('bookings', 'status'));
    }

    public function bookingVerifyPayment(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'catatan' => 'nullable|string',
        ]);

        $booking = Booking::with(['slot.lapangan', 'pembayaran', 'customer'])->findOrFail($id);

        if ($request->action === 'approve') {
            DB::transaction(function () use ($booking, $request) {
                $booking->status_booking = 'confirmed';
                $booking->save();

                if ($booking->pembayaran) {
                    $booking->pembayaran->status_bayar = 'lunas';
                    $booking->pembayaran->catatan_verifikasi = $request->catatan ?: 'Pembayaran telah dikonfirmasi dan diverifikasi oleh pemilik lapangan.';
                    $booking->pembayaran->save();
                }

                // Award Loyalty Points to Customer: 100 points per booking!
                Point::create([
                    'id_customer' => $booking->id_customer,
                    'jumlah_point' => 100,
                    'riwayat_transaksi' => 'Poin Pemesanan Dikonfirmasi #' . $booking->id_booking . ' (' . $booking->slot->lapangan->nama_lapangan . ')',
                ]);
            });

            return back()->with('success', 'Pembayaran berhasil diverifikasi! Pesanan berstatus Terkonfirmasi dan Pelanggan memperoleh 100 Poin Loyalitas.');
        } else {
            DB::transaction(function () use ($booking, $request) {
                $booking->status_booking = 'cancelled';
                $booking->save();

                if ($booking->pembayaran) {
                    $booking->pembayaran->status_bayar = 'ditolak';
                    $booking->pembayaran->catatan_verifikasi = $request->catatan ?: 'Bukti pembayaran tidak valid atau transfer belum masuk.';
                    $booking->pembayaran->save();
                }

                // Release slot back to available
                if ($booking->slot) {
                    $booking->slot->status_slot = 'tersedia';
                    $booking->slot->save();
                }
            });

            return back()->with('success', 'Pembayaran ditolak dan jadwal slot lapangan telah dibuka kembali.');
        }
    }

    public function bookingComplete($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status_booking' => 'completed']);

        return back()->with('success', 'Pesanan ditandai selesai! Pelanggan kini dapat memberikan ulasan dan rating.');
    }

    public function ulasanIndex()
    {
        $pemilikId = $this->getPemilikId();
        $lapanganIds = Lapangan::where('id_pemilik', $pemilikId)->pluck('id_lapangan');

        $ulasans = Ulasan::with(['customer', 'lapangan', 'booking'])
            ->whereIn('id_lapangan', $lapanganIds)
            ->latest('id_ulasan')
            ->paginate(15);

        return view('sportify.pemilik.ulasan', compact('ulasans'));
    }
}
