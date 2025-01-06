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
        Schema::create('ART', function (Blueprint $table) {
            $table->id('ART_ID');
            $table->unsignedBigInteger('USER_ID');
            $table->foreign('USER_ID')->references('USER_ID')->on('MASTER_USER')->onUpdate('cascade')->onDelete('cascade');
            $table->string('ART_TITLE');
            $table->text('DESCRIPTION');
            $table->double('WIDTH');
            $table->double('HEIGHT');
            $table->string('UNIT');
            $table->integer('VIEW')->default(0);
            $table->boolean('IS_SALE');
            $table->decimal('PRICE', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ART');
    }
};
