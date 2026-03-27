<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_log'; // TAMBAHKAN BARIS INI

    protected $fillable = [
        'user_id',
        'nama_user',
        'role',
        'aksi',
        'detail',
        'ip_address',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}