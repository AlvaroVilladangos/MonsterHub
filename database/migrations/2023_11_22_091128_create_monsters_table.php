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
        Schema::create('monsters', function (Blueprint $table) {

            $table->id();
            $table->string('name')->unique();
            $table->string('img');
            $table->string('element');
            $table->string('weakness');
            $table->text('physiology');
            $table->text('abilities');
            $table->boolean('blocked')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists( 'monsters' );
    }
};
