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
       Schema::create('sertifikat', function (Blueprint $table) {
        $table->id();
        $table->foreignId('peserta_id')->constrained('peserta')->cascadeOnDelete();
        $table->string('nomor_sertifikat')->unique();
        $table->date('tanggal_terbit');
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikat');
    }
};
