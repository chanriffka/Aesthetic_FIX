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
        Schema::create('HIRE_QUESTION', function (Blueprint $table) {
            $table->id('HIRE_QUESTION_ID');
            $table->unsignedBigInteger('USER_ID');
            $table->foreign('USER_ID')->references('USER_ID')->on('MASTER_USER')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('ARTIST_HIRE_ID');
            $table->foreign('ARTIST_HIRE_ID')->references('ARTIST_HIRE_ID')->on('ARTIST_HIRE')->onUpdate('no action')->onDelete('no action');
            $table->text('QUESTION');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('HIRE_QUESTION');
    }
};
