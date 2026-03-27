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
    Schema::table('users', function (Blueprint $table) {
        $table->foreignId('lembaga_id')->nullable()->constrained('lembaga')->nullOnDelete();
        $table->string('telepon', 20)->nullable();
        $table->boolean('is_active')->default(true);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['lembaga_id']);
        $table->dropColumn(['lembaga_id', 'telepon', 'is_active']);
    });
    }
};
