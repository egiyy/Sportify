<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class PemilikLapangan extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pemilik_lapangan';
    protected $primaryKey = 'id_pemilik';

    protected $fillable = [
        'nama_pemilik',
        'email',
        'password',
        'no_wa',
        'status_verifikasi',
    ];

    protected $hidden = [
        'password',
    ];

    public function lapangan()
    {
        return $this->hasMany(Lapangan::class, 'id_pemilik', 'id_pemilik');
    }
}
