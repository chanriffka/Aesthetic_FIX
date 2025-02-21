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
        Schema::create('ARTIST_REPORT', function (Blueprint $table) {
            $table->id('ARTIST_REPORT_ID');
            $table->unsignedBigInteger('ARTIST_ID');
            $table->foreign('ARTIST_ID')->references('ARTIST_ID')->on('ARTIST')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('USER_ID');
            $table->foreign('USER_ID')->references('USER_ID')->on('MASTER_USER')->onUpdate('no action')->onDelete('no action');
            $table->longText('CONTENT');
            $table->tinyInteger('STATUS')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ARTIST_REPORT');
    }
};
