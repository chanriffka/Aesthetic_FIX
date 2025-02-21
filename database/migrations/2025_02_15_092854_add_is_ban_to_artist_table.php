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
        Schema::table('ARTIST', function (Blueprint $table) {
            $table->boolean('IS_BAN')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ARTIST', function (Blueprint $table) {
            $table->dropColumn('IS_BAN'); // Rollback the change
        });
    }
};
