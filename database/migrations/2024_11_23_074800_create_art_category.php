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
        Schema::create('ART_CATEGORY', function (Blueprint $table) {
            $table->id('ART_CATEGORY_ID');
            $table->unsignedBigInteger('ART_ID');
            $table->foreign('ART_ID')->references('ART_ID')->on('ART')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('ART_CATEGORY_MASTER_ID');
            $table->foreign('ART_CATEGORY_MASTER_ID')->references('ART_CATEGORY_MASTER_ID')->on('ART_CATEGORY_MASTER')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ART_CATEGORY');
    }
};
