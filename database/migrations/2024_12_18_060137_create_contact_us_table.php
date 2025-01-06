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
        Schema::create('CONTACT_US', function (Blueprint $table) {
            $table->id('CONTACT_US_ID');
            $table->string('FULLNAME');
            $table->string('EMAIL');
            $table->string('PHONE_NUMBER');
            $table->text('MESSAGE');
            $table->tinyInteger('STATUS')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('CONTACT_US');
    }
};
