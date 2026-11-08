<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

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

    public function ulasan()
    {
        return $this->hasMany(
            Ulasan::class,
            'id_customer',
            'id_customer'
        );
    }

    public function booking()
    {
        return $this->hasMany(
            Booking::class,
            'id_customer',
            'id_customer'
        );
    }

    public function points()
    {
        return $this->hasMany(
            Point::class,
            'id_customer',
            'id_customer'
        );
    }

    public function penukaran()
    {
        return $this->hasMany(
            Penukaran::class,
            'id_customer',
            'id_customer'
        );
    }
}
