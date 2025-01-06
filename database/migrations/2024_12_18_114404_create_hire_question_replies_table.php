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
        Schema::create('HIRE_QUESTION_REPLY', function (Blueprint $table) {
            $table->id('HIRE_QUESTION_REPLY_ID');
            $table->unsignedBigInteger('USER_ID');
            $table->foreign('USER_ID')->references('USER_ID')->on('MASTER_USER')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('HIRE_QUESTION_ID');
            $table->foreign('HIRE_QUESTION_ID')->references('HIRE_QUESTION_ID')->on('HIRE_QUESTION')->onUpdate('cascade')->onDelete('cascade');
            $table->text('REPLY');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('HIRE_QUESTION_REPLY');
    }
};
