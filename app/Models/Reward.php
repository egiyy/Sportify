<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $table = 'reward';
    protected $primaryKey = 'id_reward';

    protected $fillable = [
        'nama_reward',
        'poin_dibutuhkan',
        'stok',
        'deskripsi',
        'foto',
    ];

    public function penukaran()
    {
        return $this->hasMany(Penukaran::class, 'id_reward', 'id_reward');
    }
}
