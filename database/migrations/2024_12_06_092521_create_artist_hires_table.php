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
        Schema::create('ARTIST_HIRE', function (Blueprint $table) {
            $table->id('ARTIST_HIRE_ID');
            $table->unsignedBigInteger('ARTIST_ID');
            $table->foreign('ARTIST_ID')->references('ARTIST_ID')->on('ARTIST')->onUpdate('cascade')->onDelete('cascade');
            $table->string('PROJECT_TITLE');
            $table->string('PROJECT_DESCR');
            $table->datetime('PROJECT_TIMELINE');
            $table->string('PROJECT_BUDGET');
            $table->string('PROJECT_SKILLS');
            $table->string('PROJECT_EXPERIENCE_LEVEL');
            $table->string('OTHER_REQUIREMENTS');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ARTIST_HIRE');
    }
};
