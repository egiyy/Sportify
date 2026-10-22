<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\PemilikLapangan;
use App\Models\Lapangan;
use App\Models\Slot;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\Point;
use App\Models\Reward;
use App\Models\Penukaran;
use App\Models\Ulasan;
use Carbon\Carbon;

class SportifySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        $admin = Admin::updateOrCreate(
            ['email' => 'admin@sportify.com'],
            [
                'nama_admin' => 'Administrator Sportify',
                'password' => Hash::make('admin123'),
                'no_wa' => '081234567890',
            ]
        );

        // 2. Pemilik Lapangan
        $pemilik1 = PemilikLapangan::updateOrCreate(
            ['email' => 'budi@pemilik.com'],
            [
                'nama_pemilik' => 'Budi Santoso (Champion Arena)',
                'password' => Hash::make('pemilik123'),
                'no_wa' => '081298765432',
                'status_verifikasi' => 'approved',
            ]
        );

        $pemilik2 = PemilikLapangan::updateOrCreate(
            ['email' => 'hendra@pemilik.com'],
            [
                'nama_pemilik' => 'Hendra Wijaya (Golden Sport Center)',
                'password' => Hash::make('pemilik123'),
                'no_wa' => '081377889900',
                'status_verifikasi' => 'approved',
            ]
        );

        // 3. Customer
        $customer1 = Customer::updateOrCreate(
            ['email' => 'reggy@customer.com'],
            [
                'nama' => 'Reggy Desvita Kamal',
                'password' => Hash::make('customer123'),
                'no_wa' => '081211223344',
            ]
        );

        $customer2 = Customer::updateOrCreate(
            ['email' => 'andi@customer.com'],
            [
                'nama' => 'Andi Pratama',
                'password' => Hash::make('customer123'),
                'no_wa' => '081255667788',
            ]
        );

        // 4. Lapangan
        $lapangan1 = Lapangan::updateOrCreate(
            ['nama_lapangan' => 'Champion Futsal Sintetis (A)'],
            [
                'id_pemilik' => $pemilik1->id_pemilik,
                'id_admin' => $admin->id_admin,
                'jenis_olahraga' => 'Futsal',
                'lokasi' => 'Jl. ZA. Pagar Alam No. 45, Gedong Meneng, Bandar Lampung',
                'harga_per_jam' => 120000,
                'deskripsi' => 'Lapangan futsal rumput sintetis standar nasional, pencahayaan LED terang, ventilasi sejuk, papan skor digital, dan ruang ganti ber-AC.',
                'foto' => 'https://images.unsplash.com/photo-1529900748604-07564a03e7a6?w=800&auto=format&fit=crop&q=80',
                'status_verifikasi' => 'approved',
            ]
        );

        $lapangan2 = Lapangan::updateOrCreate(
            ['nama_lapangan' => 'Champion Futsal Vinyl Interlock (B)'],
            [
                'id_pemilik' => $pemilik1->id_pemilik,
                'id_admin' => $admin->id_admin,
                'jenis_olahraga' => 'Futsal',
                'lokasi' => 'Jl. ZA. Pagar Alam No. 45, Gedong Meneng, Bandar Lampung',
                'harga_per_jam' => 135000,
                'deskripsi' => 'Lantai vinyl interlock empuk mengurangi risiko cedera lutut. Cocok untuk turnamen dan latihan tim futsal profesional.',
                'foto' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=800&auto=format&fit=crop&q=80',
                'status_verifikasi' => 'approved',
            ]
        );

        $lapangan3 = Lapangan::updateOrCreate(
            ['nama_lapangan' => 'Golden Badminton Hall Court 1'],
            [
                'id_pemilik' => $pemilik2->id_pemilik,
                'id_admin' => $admin->id_admin,
                'jenis_olahraga' => 'Badminton',
                'lokasi' => 'Jl. Teuku Umar No. 12, Kedaton, Bandar Lampung',
                'harga_per_jam' => 60000,
                'deskripsi' => 'Karpet badminton standar BWF tebal 4.5mm, tiang dan net kokoh, bebas silau angin tertutup.',
                'foto' => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?w=800&auto=format&fit=crop&q=80',
                'status_verifikasi' => 'approved',
            ]
        );

        $lapangan4 = Lapangan::updateOrCreate(
            ['nama_lapangan' => 'Golden Basketball Court Indoor'],
            [
                'id_pemilik' => $pemilik2->id_pemilik,
                'id_admin' => $admin->id_admin,
                'jenis_olahraga' => 'Basket',
                'lokasi' => 'Jl. Teuku Umar No. 12, Kedaton, Bandar Lampung',
                'harga_per_jam' => 150000,
                'deskripsi' => 'Lantai kayu parket premium full court, ring hidrolik dengan papan pantul kaca tempered glass.',
                'foto' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800&auto=format&fit=crop&q=80',
                'status_verifikasi' => 'approved',
            ]
        );

        // 5. Rewards Catalog
        $rewards = [
            [
                'nama_reward' => 'Air Mineral Dingin 600ml',
                'poin_dibutuhkan' => 30,
                'stok' => 50,
                'deskripsi' => 'Segarkan tubuh setelah lelah bertanding dengan air mineral murni berkualitas.',
                'foto' => 'https://images.unsplash.com/photo-1560023907-5f339617ea30?w=600&auto=format&fit=crop&q=80',
            ],
            [
                'nama_reward' => 'Pocari Sweat Isotonik 500ml',
                'poin_dibutuhkan' => 60,
                'stok' => 30,
                'deskripsi' => 'Gantikan ion dan cairan tubuh yang hilang selama olahraga dengan minuman isotonik terbaik.',
                'foto' => 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?w=600&auto=format&fit=crop&q=80',
            ],
            [
                'nama_reward' => 'Handuk Olahraga Microfiber Sportify',
                'poin_dibutuhkan' => 150,
                'stok' => 20,
                'deskripsi' => 'Handuk microfiber cepat serap keringat, lembut dan mudah dibawa dengan logo resmi Sportify.',
                'foto' => 'https://images.unsplash.com/photo-1607344645866-009c320c5ab8?w=600&auto=format&fit=crop&q=80',
            ],
            [
                'nama_reward' => 'Kaos Kaki Futsal Anti-Slip',
                'poin_dibutuhkan' => 180,
                'stok' => 15,
                'deskripsi' => 'Kaos kaki grip pad anti licin, mencengkeram sepatu futsal dengan mantap saat akselerasi.',
                'foto' => 'https://images.unsplash.com/photo-1586350977771-b3b0abd50c82?w=600&auto=format&fit=crop&q=80',
            ],
            [
                'nama_reward' => 'Jersey Eksklusif Sportify Edition',
                'poin_dibutuhkan' => 450,
                'stok' => 10,
                'deskripsi' => 'Jersey dry-fit eksklusif edisi terbatas Sportify dengan sablon reflektif premium.',
                'foto' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=600&auto=format&fit=crop&q=80',
            ],
            [
                'nama_reward' => 'Voucher Diskon Sewa 50% (Max 75k)',
                'poin_dibutuhkan' => 500,
                'stok' => 12,
                'deskripsi' => 'Potongan langsung sewa lapangan apa saja di seluruh venue rekanan Sportify.',
                'foto' => 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=600&auto=format&fit=crop&q=80',
            ],
        ];

        foreach ($rewards as $r) {
            Reward::updateOrCreate(['nama_reward' => $r['nama_reward']], $r);
        }

        // 6. Slots Generation for Today & Next 3 Days
        $lapangans = [$lapangan1, $lapangan2, $lapangan3, $lapangan4];
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

        $today = Carbon::today();

        for ($day = 0; $day <= 3; $day++) {
            $date = $today->copy()->addDays($day)->toDateString();
            foreach ($lapangans as $lap) {
                foreach ($timeSlots as $slotTime) {
                    Slot::firstOrCreate(
                        [
                            'id_lapangan' => $lap->id_lapangan,
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
        }

        // 7. Seed Past Completed Bookings & Active Bookings for Demo
        // Booking 1: Reggy (Completed)
        $slot1 = Slot::where('id_lapangan', $lapangan1->id_lapangan)->first();
        if ($slot1 && !$slot1->booking) {
            $slot1->update(['status_slot' => 'dibooking']);
            $b1 = Booking::create([
                'id_customer' => $customer1->id_customer,
                'id_slot' => $slot1->id_slot,
                'id_admin' => $admin->id_admin,
                'tanggal_booking' => Carbon::now()->subDays(2),
                'total_harga' => $lapangan1->harga_per_jam,
                'status_booking' => 'completed',
                'catatan' => 'Main futsal bareng teman angkatan Ilkom UNILA.',
            ]);

            Pembayaran::create([
                'id_booking' => $b1->id_booking,
                'metode_bayar' => 'QRIS',
                'status_bayar' => 'lunas',
                'waktu_transaksi' => Carbon::now()->subDays(2),
                'bukti_bayar' => 'https://dummyimage.com/600x400/10b981/ffffff&text=BUKTI+BAYAR+QRIS+LUNAS',
                'catatan_verifikasi' => 'Pembayaran QRIS telah diverifikasi lunas.',
            ]);

            Ulasan::create([
                'id_booking' => $b1->id_booking,
                'id_customer' => $customer1->id_customer,
                'id_lapangan' => $lapangan1->id_lapangan,
                'rating' => 5,
                'komentar' => 'Lapangannya sangat bersih, rumput sintetisnya empuk dan lampu penerangannya mantap! Sangat recommended.',
                'balasan_pemilik' => 'Terima kasih banyak Kak Reggy! Ditunggu kedatangannya kembali bersama tim.',
                'tanggal_balasan' => Carbon::now()->subDay(),
            ]);
        }

        // Booking 2: Andi (Pending Payment Approval)
        $slot2 = Slot::where('id_lapangan', $lapangan2->id_lapangan)->skip(1)->first();
        if ($slot2 && !$slot2->booking) {
            $slot2->update(['status_slot' => 'dibooking']);
            $b2 = Booking::create([
                'id_customer' => $customer2->id_customer,
                'id_slot' => $slot2->id_slot,
                'id_admin' => $admin->id_admin,
                'tanggal_booking' => Carbon::now(),
                'total_harga' => $lapangan2->harga_per_jam,
                'status_booking' => 'pending',
                'catatan' => 'Latihan sparing mingguan.',
            ]);

            Pembayaran::create([
                'id_booking' => $b2->id_booking,
                'metode_bayar' => 'Transfer Bank BCA',
                'status_bayar' => 'pending',
                'waktu_transaksi' => Carbon::now(),
                'bukti_bayar' => 'https://dummyimage.com/600x400/3b82f6/ffffff&text=TRANSFER+BCA+Rp135.000',
                'catatan_verifikasi' => 'Menunggu pengecekan mutasi bank oleh pemilik lapangan.',
            ]);
        }

        // 8. Points & Loyalty History
        Point::firstOrCreate(
            ['riwayat_transaksi' => 'Reward Pemesanan Selesai Lapangan Sintetis #1'],
            [
                'id_customer' => $customer1->id_customer,
                'jumlah_point' => 150,
            ]
        );
        Point::firstOrCreate(
            ['riwayat_transaksi' => 'Bonus Pendaftaran Member Baru Sportify'],
            [
                'id_customer' => $customer1->id_customer,
                'jumlah_point' => 100,
            ]
        );
        Point::firstOrCreate(
            ['riwayat_transaksi' => 'Reward Pemesanan Selesai Lapangan Badminton #2'],
            [
                'id_customer' => $customer1->id_customer,
                'jumlah_point' => 120,
            ]
        );

        Point::firstOrCreate(
            ['riwayat_transaksi' => 'Bonus Pendaftaran Member Baru Sportify'],
            [
                'id_customer' => $customer2->id_customer,
                'jumlah_point' => 100,
            ]
        );

        // 9. Sample Penukaran Reward
        $rewardSample = Reward::where('nama_reward', 'like', '%Pocari%')->first();
        if ($rewardSample) {
            Penukaran::firstOrCreate(
                [
                    'id_customer' => $customer1->id_customer,
                    'id_reward' => $rewardSample->id_reward,
                ],
                [
                    'tanggal_tukar' => Carbon::now()->subDays(1),
                    'status_penukaran' => 'selesai',
                ]
            );
        }
    }
}
