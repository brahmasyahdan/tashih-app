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
        Schema::create('peserta', function (Blueprint $table) {
        $table->id();
        $table->foreignId('lembaga_id')->constrained('lembaga')->cascadeOnDelete();
        $table->string('nama_peserta');
        $table->string('nis', 30)->nullable();
        $table->enum('jenis_kelamin', ['L', 'P']);
        $table->date('tanggal_lahir')->nullable();
        $table->string('alamat')->nullable();
        $table->year('tahun_ujian');
        $table->enum('status_nilai', ['draft', 'lengkap'])->default('draft');
        $table->decimal('nilai_akhir', 5, 2)->nullable();
        $table->string('predikat', 30)->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta');
    }
};
