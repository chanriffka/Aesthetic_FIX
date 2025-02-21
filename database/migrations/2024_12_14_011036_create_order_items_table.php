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
        Schema::create('ORDER_ITEM', function (Blueprint $table) {
            $table->id('ORDER_ITEM_ID');
            $table->unsignedBigInteger('ORDER_ID');
            $table->foreign('ORDER_ID')->references('ORDER_ID')->on('ORDER')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('ART_ID');
            $table->foreign('ART_ID')->references('ART_ID')->on('ART')->onUpdate('no action')->onDelete('no action');
            $table->integer('QUANTITY');
            $table->integer('PRICE_PER_ITEM');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ORDER_ITEM');
    }
};
