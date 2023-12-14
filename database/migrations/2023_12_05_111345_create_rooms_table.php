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
        Schema::create('rooms', function (Blueprint $table) {
            $table -> id();
            $table -> unsignedBigInteger('hunter_1')->unique();
            $table -> unsignedBigInteger('hunter_2')->unique();
            $table -> unsignedBigInteger('hunter_3')->unique();
            $table -> unsignedBigInteger('hunter_4')->unique();
            $table -> unsignedBigInteger('monster_id');
            $table -> integer('room_number')->unique()->unsigned();

            $table->foreign('hunter_1')->references('id')->on('hunters');
            $table->foreign('hunter_2')->references('id')->on('hunters');
            $table->foreign('hunter_3')->references('id')->on('hunters');
            $table->foreign('hunter_4')->references('id')->on('hunters');
            $table->foreign('monster_id')->references('id')->on('monsters');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
