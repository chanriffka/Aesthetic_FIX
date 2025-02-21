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
        Schema::create('ART_COLLECTION', function (Blueprint $table) {
            $table->id('ART_COLLECTION_ID');
            $table->unsignedBigInteger('ARTIST_COLLECTION_ID');
            $table->foreign('ARTIST_COLLECTION_ID')->references('ARTIST_COLLECTION_ID')->on('ARTIST_COLLECTION')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('ART_ID');
            $table->foreign('ART_ID')->references('ART_ID')->on('ART')->onUpdate('no action')->onDelete('no action');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ART_COLLECTION');
    }
};
