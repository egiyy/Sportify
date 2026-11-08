<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use App\Models\Slot;
use App\Models\Reward;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');
        $sport = $request->query('sport');

        $query = Lapangan::with(['pemilik', 'ulasan'])
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
        $rewards = Reward::where('stok', '>', 0)->take(4)->get();

        $stats = [
            'total_lapangan' => Lapangan::where('status_verifikasi', 'approved')->count(),
            'total_sports' => Lapangan::distinct('jenis_olahraga')->count('jenis_olahraga') ?: 4,
            'total_rewards' => Reward::count(),
        ];

        return view('sportify.home', compact('lapangans', 'rewards', 'stats', 'search', 'sport'));
    }

    public function lapanganDetail(Request $request, $id)
    {
        $lapangan = Lapangan::with(['pemilik', 'ulasan.customer'])->findOrFail($id);

        $selectedDate = $request->query('tanggal', Carbon::today()->toDateString());

        // Get slots for this lapangan on selectedDate
        $slots = Slot::where('id_lapangan', $id)
            ->where('tanggal', $selectedDate)
            ->orderBy('jam_mulai')
            ->get();

        // If no slots exist for this date yet, auto-generate standard slots so user can test seamlessly!
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

        return view('sportify.lapangan_detail', compact('lapangan', 'slots', 'selectedDate'));
    }

    public function about()
    {
        return view('sportify.about');
    }
}
