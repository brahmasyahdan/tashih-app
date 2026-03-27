<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembaga extends Model
{
    use HasFactory;

    protected $table = 'lembaga';

    protected $fillable = [
        'nama_lembaga',
        'kode_lembaga',
        'alamat',
        'telepon',
        'email',
        'nama_kepala',
        'logo',
        'is_active',
    ];

    // Relasi: satu lembaga punya banyak peserta
    public function peserta()
    {
        return $this->hasMany(Peserta::class);
    }

    // Relasi: satu lembaga punya banyak user
    public function users()
    {
        return $this->hasMany(User::class);
    }
}