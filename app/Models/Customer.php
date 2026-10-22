<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'customer';
    protected $primaryKey = 'id_customer';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_wa',
    ];

    protected $hidden = [
        'password',
    ];

    public function booking()
    {
        return $this->hasMany(Booking::class, 'id_customer', 'id_customer');
    }

    public function points()
    {
        return $this->hasMany(Point::class, 'id_customer', 'id_customer')->latest('created_at');
    }

    public function penukaran()
    {
        return $this->hasMany(Penukaran::class, 'id_customer', 'id_customer')->latest('created_at');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'id_customer', 'id_customer');
    }

    public function getTotalPoinAttribute()
    {
        return $this->points()->sum('jumlah_point') ?? 0;
    }
}
