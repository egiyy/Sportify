<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    use HasFactory;

    protected $table = 'lapangan';
    protected $primaryKey = 'id_lapangan';

    protected $fillable = [
        'id_pemilik',
        'id_admin',
        'nama_lapangan',
        'jenis_olahraga',
        'lokasi',
        'harga_per_jam',
        'deskripsi',
        'foto',
        'status_verifikasi',
    ];

    // Relasi pemilik lapangan
    public function pemilik()
    {
        return $this->belongsTo(
            PemilikLapangan::class,
            'id_pemilik',
            'id_pemilik'
        );
    }

    // Relasi admin
    public function admin()
    {
        return $this->belongsTo(
            Admin::class,
            'id_admin',
            'id_admin'
        );
    }

    // Relasi ulasan
    public function ulasan()
    {
        return $this->hasMany(
            Ulasan::class,
            'id_lapangan',
            'id_lapangan'
        );
    }

    // Relasi slot lapangan
    public function slots()
    {
        return $this->hasMany(
            Slot::class,
            'id_lapangan',
            'id_lapangan'
        );
    }
}
