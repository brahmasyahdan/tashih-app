<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    use HasFactory;

    protected $table = 'sertifikat'; // Tambahkan ini

    protected $fillable = [
        'peserta_id', 'nomor_sertifikat', 'tanggal_terbit', 'is_active',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }
}