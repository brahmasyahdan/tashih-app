<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peserta', function (Blueprint $table) {
            $table->string('nama_ayah')->nullable()->after('nama_peserta');
            $table->string('nama_ibu')->nullable()->after('nama_ayah');
        });
    }

    public function down(): void
    {
        Schema::table('peserta', function (Blueprint $table) {
            $table->dropColumn(['nama_ayah', 'nama_ibu']);
        });
    }
};