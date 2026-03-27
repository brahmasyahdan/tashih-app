<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->boolean('edited_by_admin')->default(false)->after('is_final');
            $table->timestamp('last_edited_at')->nullable()->after('edited_by_admin');
        });
    }

    public function down(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->dropColumn(['edited_by_admin', 'last_edited_at']);
        });
    }
};