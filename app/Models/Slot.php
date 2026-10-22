<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $table = 'slot';
    protected $primaryKey = 'id_slot';

    protected $fillable = [
        'id_lapangan',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status_slot',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class, 'id_lapangan', 'id_lapangan');
    }

    public function booking()
    {
        return $this->hasOne(Booking::class, 'id_slot', 'id_slot');
    }
}
