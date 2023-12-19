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
        Schema::create('hunters', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->string('name')->unique();
            $table->string('bio')->default('');
            $table->unsignedBigInteger('guild_id')->nullable();
            $table->unsignedBigInteger('weapon_id');
            $table->unsignedBigInteger('armor_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('weapon_id')->references('id')->on('weapons')
                ->onDelete('cascade');
            $table->foreign('armor_id')->references('id')->on('armors')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hunters');
    }
};
