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
        Schema::create('FOLLOWER', function (Blueprint $table) {
            $table->id('FOLLOWER_ID');
            $table->unsignedBigInteger('FOLLOWER_USER_ID');
            $table->unsignedBigInteger('FOLLOWED_USER_ID');
            $table->timestamps();

            // $table->unique(['FOLLOWER_USER_ID', 'FOLLOWED_USER_ID']);
            // Foreign key for FOLLOWER_ID with cascade delete
            $table->foreign('FOLLOWER_USER_ID')->references('USER_ID')->on('MASTER_USER')->onUpdate('cascade')->onDelete('cascade');

            // Foreign key for FOLLOWED_ID without cascade delete
            $table->foreign('FOLLOWED_USER_ID')->references('USER_ID')->on('MASTER_USER')->onUpdate('cascade')->onDelete('cascade');
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('FOLLOWER');
    }
};
