<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penguji_materi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('materi_id')->constrained('materi')->cascadeOnDelete();
            $table->timestamps();

            // Pastikan satu penguji tidak ditugaskan ke materi yang sama 2x
            $table->unique(['user_id', 'materi_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penguji_materi');
    }
};