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

    public function pemilik()
    {
        return $this->belongsTo(PemilikLapangan::class, 'id_pemilik', 'id_pemilik');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function slots()
    {
        return $this->hasMany(Slot::class, 'id_lapangan', 'id_lapangan')->orderBy('tanggal')->orderBy('jam_mulai');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'id_lapangan', 'id_lapangan')->latest('created_at');
    }

    public function getAverageRatingAttribute()
    {
        return round($this->ulasan()->avg('rating') ?: 5.0, 1);
    }
}
