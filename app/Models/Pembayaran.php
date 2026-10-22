<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'id_booking',
        'metode_bayar',
        'status_bayar',
        'waktu_transaksi',
        'bukti_bayar',
        'catatan_verifikasi',
    ];

    protected $casts = [
        'waktu_transaksi' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking', 'id_booking');
    }
}
