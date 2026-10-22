<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Reward;
use App\Models\Customer;
use App\Models\Point;
use App\Models\Penukaran;
use Carbon\Carbon;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::orderBy('poin_dibutuhkan')->get();
        $customer = null;
        $pointsHistory = collect();
        $penukaranHistory = collect();
        $totalPoin = 0;

        if (session()->has('sportify_user_id') && session('sportify_user_role') === 'customer') {
            $customer = Customer::find(session('sportify_user_id'));
            if ($customer) {
                $totalPoin = $customer->total_poin;
                $pointsHistory = $customer->points()->take(10)->get();
                $penukaranHistory = $customer->penukaran()->with('reward')->take(10)->get();
            }
        }

        return view('sportify.customer.rewards', compact('rewards', 'customer', 'totalPoin', 'pointsHistory', 'penukaranHistory'));
    }

    public function redeem(Request $request, $id)
    {
        if (!session()->has('sportify_user_id') || session('sportify_user_role') !== 'customer') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai customer untuk menukarkan poin reward.');
        }

        $customerId = session('sportify_user_id');
        $customer = Customer::findOrFail($customerId);
        $reward = Reward::findOrFail($id);

        if ($reward->stok <= 0) {
            return back()->with('error', 'Mohon maaf, stok hadiah ini sedang habis.');
        }

        if ($customer->total_poin < $reward->poin_dibutuhkan) {
            return back()->with('error', 'Poin Anda tidak mencukupi untuk menukarkan hadiah ini. Kumpulkan poin lebih banyak dengan memesan lapangan olahraga!');
        }

        DB::transaction(function () use ($customer, $reward) {
            // Deduct points
            Point::create([
                'id_customer' => $customer->id_customer,
                'jumlah_point' => -$reward->poin_dibutuhkan,
                'riwayat_transaksi' => 'Penukaran Hadiah: ' . $reward->nama_reward,
            ]);

            // Reduce stock
            $reward->decrement('stok');

            // Record redemption
            Penukaran::create([
                'id_customer' => $customer->id_customer,
                'id_reward' => $reward->id_reward,
                'tanggal_tukar' => Carbon::now(),
                'status_penukaran' => 'selesai',
            ]);
        });

        return back()->with('success', 'Selamat! Penukaran hadiah "' . $reward->nama_reward . '" berhasil. Silakan tunjukkan bukti penukaran ini ke pengelola venue!');
    }
}
