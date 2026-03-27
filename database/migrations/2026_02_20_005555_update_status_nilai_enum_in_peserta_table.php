<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Ubah kolom jadi VARCHAR dulu (temporary)
        DB::statement("ALTER TABLE peserta MODIFY COLUMN status_nilai VARCHAR(50) DEFAULT 'draft'");
        
        // Step 2: Update semua data lama
        DB::table('peserta')
            ->where('status_nilai', 'draft')
            ->update(['status_nilai' => 'belum_dinilai']);
        
        DB::table('peserta')
            ->where('status_nilai', 'lengkap')
            ->update(['status_nilai' => 'lengkap']);
        
        // Step 3: Ubah jadi ENUM baru
        DB::statement("ALTER TABLE peserta MODIFY COLUMN status_nilai ENUM('belum_dinilai', 'sedang_dinilai', 'lengkap') DEFAULT 'belum_dinilai'");
    }

    public function down(): void
    {
        // Kembalikan ke ENUM lama
        DB::statement("ALTER TABLE peserta MODIFY COLUMN status_nilai VARCHAR(50) DEFAULT 'draft'");
        
        DB::table('peserta')
            ->whereIn('status_nilai', ['sedang_dinilai', 'belum_dinilai'])
            ->update(['status_nilai' => 'draft']);
        
        DB::statement("ALTER TABLE peserta MODIFY COLUMN status_nilai ENUM('draft', 'lengkap') DEFAULT 'draft'");
    }
};