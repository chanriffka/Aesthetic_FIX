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
        Schema::create('POST_COMMENT', function (Blueprint $table) {
            $table->id('POST_COMMENT_ID');
            $table->unsignedBigInteger('USER_ID');
            $table->foreign('USER_ID')->references('USER_ID')->on('MASTER_USER')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('POST_ID');
            $table->foreign('POST_ID')->references('POST_ID')->on('POST')->onUpdate('cascade')->onDelete('cascade');
            $table->text('CONTENT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('POST_COMMENT');
    }
};
