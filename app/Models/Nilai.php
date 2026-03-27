<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai'; // Tambahkan ini

    protected $fillable = [
        'peserta_id', 'materi_id', 'item_materi_id',
        'penguji_id', 'nilai', 'catatan', 'is_final', 
        'edited_by_admin', 'last_edited_at', // Tambahkan ini
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }

    public function itemMateri()
    {
        return $this->belongsTo(ItemMateri::class);
    }

    public function penguji()
    {
        return $this->belongsTo(User::class, 'penguji_id');
    }
}