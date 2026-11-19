<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use App\Models\Slot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');
        $sport = $request->query('sport');

        $withRelations = ['pemilik'];
        if (Schema::hasTable('ulasan')) {
            $withRelations[] = 'ulasan';
        }

        $query = Lapangan::with($withRelations)
            ->where('status_verifikasi', 'approved');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lapangan', 'ilike', "%{$search}%")
                  ->orWhere('lokasi', 'ilike', "%{$search}%")
                  ->orWhere('deskripsi', 'ilike', "%{$search}%");
            });
        }

        if ($sport && $sport !== 'semua') {
            $query->where('jenis_olahraga', 'ilike', $sport);
        }

        $lapangans = $query->latest('id_lapangan')->get();

        $stats = [
            'total_lapangan' => Lapangan::where('status_verifikasi', 'approved')->count(),
            'total_sports' => Lapangan::distinct('jenis_olahraga')->count('jenis_olahraga') ?: 4,
        ];

        return view('sportify.home', compact(
            'lapangans',
            'stats',
            'search',
            'sport'
        ));
    }

    public function lapanganDetail(Request $request, $id)
    {
        $withRelations = ['pemilik'];
        if (Schema::hasTable('ulasan')) {
            $withRelations[] = 'ulasan.customer';
        }

        $lapangan = Lapangan::with($withRelations)
            ->findOrFail($id);

        $currentUserRole = session('sportify_user_role');
        $currentUserId = session('sportify_user_id');
        $isOwner = ($currentUserRole === 'pemilik' && $lapangan->id_pemilik == $currentUserId);
        $isAdmin = ($currentUserRole === 'admin');

        if ($lapangan->status_verifikasi !== 'approved' && !$isOwner && !$isAdmin) {
            abort(404, 'Lapangan ini sedang dalam tahap verifikasi atau tidak aktif.');
        }

        $selectedDate = $request->query(
            'tanggal',
            Carbon::today()->toDateString()
        );

        $slots = Slot::where('id_lapangan', $id)
            ->where('tanggal', $selectedDate)
            ->orderBy('jam_mulai')
            ->get();

        // Generate slot standar jika belum tersedia.
        if ($slots->isEmpty()) {
            $timeSlots = [
                ['08:00', '09:00'],
                ['09:00', '10:00'],
                ['14:00', '15:00'],
                ['15:00', '16:00'],
                ['16:00', '17:00'],
                ['18:00', '19:00'],
                ['19:00', '20:00'],
                ['20:00', '21:00'],
                ['21:00', '22:00'],
            ];

            foreach ($timeSlots as $slotTime) {
                Slot::firstOrCreate(
                    [
                        'id_lapangan' => $id,
                        'tanggal' => $selectedDate,
                        'jam_mulai' => $slotTime[0],
                    ],
                    [
                        'jam_selesai' => $slotTime[1],
                        'status_slot' => 'tersedia',
                    ]
                );
            }

            $slots = Slot::where('id_lapangan', $id)
                ->where('tanggal', $selectedDate)
                ->orderBy('jam_mulai')
                ->get();
        }

        return view(
            'sportify.lapangan_detail',
            compact('lapangan', 'slots', 'selectedDate')
        );
    }

    // Mengambil status slot terbaru dalam format JSON.
    public function getSlots(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
        ]);

        $lapangan = Lapangan::findOrFail($id);

        $slots = Slot::where('id_lapangan', $lapangan->id_lapangan)
            ->where('tanggal', $request->tanggal)
            ->orderBy('jam_mulai')
            ->get();

        return response()->json($slots);
    }

    public function about()
    {
        return view('sportify.about');
    }
}
