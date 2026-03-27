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
        Schema::create('item_materi', function (Blueprint $table) {
        $table->id();
        $table->foreignId('materi_id')->constrained('materi')->cascadeOnDelete();
        $table->string('nama_item');
        $table->decimal('nilai_max', 5, 2)->default(100);
        $table->integer('urutan')->default(0);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_materi');
    }
};
