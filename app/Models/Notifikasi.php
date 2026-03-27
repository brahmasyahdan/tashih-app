<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi'; // Tambahkan ini

    protected $fillable = [
        'user_id', 'judul', 'pesan', 'tipe', 'is_read', 'read_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}