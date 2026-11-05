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

    // Relasi: Satu lapangan dimiliki oleh satu Pemilik Lapangan
    public function pemilik()
    {
        return $this->belongsTo(PemilikLapangan::class, 'id_pemilik', 'id_pemilik');
    }

    // Relasi: Satu lapangan diverifikasi oleh Admin
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
}