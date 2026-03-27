<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi'; // Tambahkan ini

    protected $fillable = [
        'nama_materi', 'deskripsi', 'urutan', 'bobot', 'is_active',
    ];

    public function itemMateri()
    {
        return $this->hasMany(ItemMateri::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }
    // Tambahkan di dalam class Materi

    public function penguji()
    {
        return $this->belongsToMany(User::class, 'penguji_materi', 'materi_id', 'user_id')
                    ->withTimestamps();
    }
}