<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nilai', function (Blueprint $table) {
        $table->id();
        $table->foreignId('peserta_id')->constrained('peserta')->cascadeOnDelete();
        $table->foreignId('materi_id')->constrained('materi')->cascadeOnDelete();
        $table->foreignId('item_materi_id')->constrained('item_materi')->cascadeOnDelete();
        $table->foreignId('penguji_id')->constrained('users')->cascadeOnDelete();
        $table->decimal('nilai', 5, 2)->default(0);
        $table->text('catatan')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
