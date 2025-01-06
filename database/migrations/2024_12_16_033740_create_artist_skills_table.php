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
        Schema::create('ARTIST_SKILL', function (Blueprint $table) {
            $table->id('ARTIST_SKILL_ID');
            $table->unsignedBigInteger('ARTIST_ID');
            $table->foreign('ARTIST_ID')->references('ARTIST_ID')->on('ARTIST')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('SKILL_MASTER_ID');
            $table->foreign('SKILL_MASTER_ID')->references('SKILL_MASTER_ID')->on('SKILL_MASTER')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ARTIST_SKILL');
    }
};
