<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';

protected $fillable = [
    'lembaga_id', 'nama_peserta', 'nama_ayah', 'nama_ibu',
    'nis', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
    'tahun_ujian', 'nilai_akhir', 'predikat', 'status_nilai',
];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function lembaga()
    {
        return $this->belongsTo(Lembaga::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function sertifikat()
    {
        return $this->hasOne(Sertifikat::class);
    }
}