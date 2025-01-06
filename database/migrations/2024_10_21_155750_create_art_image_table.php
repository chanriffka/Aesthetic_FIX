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
        Schema::create('ART_IMAGE', function (Blueprint $table) {
            $table->id('ART_IMAGE_ID');
            $table->unsignedBigInteger('ART_ID');
            $table->foreign('ART_ID')->references('ART_ID')->on('ART')->onUpdate('cascade')->onDelete('cascade');
            $table->string('IMAGE_PATH')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ART_IMAGE');
    }
};
