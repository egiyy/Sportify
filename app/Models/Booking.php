<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';
    protected $primaryKey = 'id_booking';

    protected $fillable = [
        'id_customer',
        'id_slot',
        'id_admin',
        'tanggal_booking',
        'total_harga',
        'status_booking',
        'catatan',
    ];

    protected $casts = [
        'tanggal_booking' => 'datetime',
        'total_harga' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class, 'id_slot', 'id_slot');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_booking', 'id_booking');
    }

    public function ulasan()
    {
        return $this->hasOne(Ulasan::class, 'id_booking', 'id_booking');
    }
}
