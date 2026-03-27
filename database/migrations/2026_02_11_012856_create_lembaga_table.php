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
    Schema::create('lembaga', function (Blueprint $table) {
        $table->id();
        $table->string('nama_lembaga');
        $table->string('kode_lembaga', 10)->unique();
        $table->string('alamat')->nullable();
        $table->string('telepon', 20)->nullable();
        $table->string('email')->nullable();
        $table->string('nama_kepala')->nullable();
        $table->string('logo')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembaga');
    }
};
