<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemMateri extends Model
{
    use HasFactory;

    protected $table = 'item_materi'; // Tambahkan ini

    protected $fillable = [
        'materi_id', 'nama_item', 'nilai_max', 'urutan', 'is_active',
    ];

    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }
}