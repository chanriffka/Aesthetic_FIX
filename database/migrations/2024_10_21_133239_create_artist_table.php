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
        Schema::create('ARTIST', function (Blueprint $table) {
            $table->id('ARTIST_ID');
            $table->unsignedBigInteger('USER_ID');
            $table->foreign('USER_ID')->references('USER_ID')->on('MASTER_USER')->onUpdate('cascade')->onDelete('cascade');
            $table->string('LOCATION');
            $table->string('ROLE');
            $table->string('BIO');
            $table->text('ABOUT');
            $table->string('X')->nullable();
            $table->string('PINTEREST')->nullable();
            $table->string('INSTAGRAM')->nullable();
            $table->string('LINKEDIN')->nullable();
            $table->boolean('IS_ACTIVE')->default(false);
            $table->integer('VIEW')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ARTIST');
    }
};
