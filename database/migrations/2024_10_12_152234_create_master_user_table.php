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
        Schema::create('MASTER_USER', function (Blueprint $table) {
            $table->id('USER_ID');
            $table->string('USERNAME',20);
            $table->string('EMAIL');
            $table->string('PASSWORD',255);
            $table->string('PROFILE_IMAGE_PATH')->nullable();
            $table->integer('USER_LEVEL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('MASTER_USER');
    }
};
