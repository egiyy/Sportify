<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemilikLapangan extends Model
{
    use HasFactory;

    protected $table = 'pemilik_lapangan';
    protected $primaryKey = 'id_pemilik';

    public function lapangan()
    {
        return $this->hasMany(
            Lapangan::class,
            'id_pemilik',
            'id_pemilik'
        );
    }
}
