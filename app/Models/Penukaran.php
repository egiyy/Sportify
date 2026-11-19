<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penukaran extends Model
{
    use HasFactory;

    protected $table = 'penukaran';
    protected $primaryKey = 'id_penukaran';

    protected $fillable = [
        'id_customer',
        'id_reward',
        'tanggal_tukar',
        'status_penukaran',
    ];

    protected $casts = [
        'tanggal_tukar' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class, 'id_reward', 'id_reward');
    }
}
