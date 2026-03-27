<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Materi; // Tambahkan ini

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'lembaga_id',
        'telepon',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke lembaga
    public function lembaga()
    {
        return $this->belongsTo(Lembaga::class);
    }

    // Relasi ke notifikasi
    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'user_id');
    }

    // Tambahkan di dalam class User, setelah relasi yang sudah ada

    public function materiYangDiuji()
    {
        return $this->belongsToMany(Materi::class, 'penguji_materi', 'user_id', 'materi_id')
                    ->withTimestamps();
    }
}