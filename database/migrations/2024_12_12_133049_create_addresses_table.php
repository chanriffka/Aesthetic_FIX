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
        Schema::create('ADDRESS', function (Blueprint $table) {
            $table->id('ADDRESS_ID');
            $table->unsignedBigInteger('USER_ID');
            $table->foreign('USER_ID')->references('USER_ID')->on('MASTER_USER')->onUpdate('cascade')->onDelete('cascade');
            $table->string('FULLNAME');
            $table->string('PHONE');
            $table->string('ADDRESS');
            $table->string('PROVINCE');
            $table->string('CITY');
            $table->string('POSTAL_CODE');
            $table->boolean('IS_ACTIVE')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ADDRESS');
    }
};
