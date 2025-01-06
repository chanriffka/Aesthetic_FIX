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
        Schema::create('POST_MEDIA', function (Blueprint $table) {
            $table->id('POST_MEDIA_ID');
            $table->unsignedBigInteger('POST_ID');
            $table->foreign('POST_ID')->references('POST_ID')->on('POST')->onUpdate('cascade')->onDelete('cascade');
            $table->char('POST_MEDIA_PATH')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('POST_MEDIA');
    }
};
