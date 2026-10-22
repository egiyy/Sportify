<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';

    protected $fillable = [
        'nama_admin',
        'email',
        'password',
        'no_wa',
    ];

    protected $hidden = [
        'password',
    ];

    public function lapangan()
    {
        return $this->hasMany(Lapangan::class, 'id_admin', 'id_admin');
    }

    public function booking()
    {
        return $this->hasMany(Booking::class, 'id_admin', 'id_admin');
    }
}
