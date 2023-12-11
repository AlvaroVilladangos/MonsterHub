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
        Schema::create( 'weapons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('atk');
            $table->string('element');
            $table->string('info');
            $table->unsignedBigInteger('monster_id');

            $table->foreign('monster_id')->references('id')->on('monsters')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists( 'weapons' );
    }
};
