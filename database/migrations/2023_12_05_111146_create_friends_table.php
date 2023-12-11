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
        Schema::create('friends', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('hunter_id1');
            $table->unsignedBigInteger('friend_id');

            $table->foreign('hunter_id1')->references('id')->on('hunters')
                ->onDelete('cascade');
            $table->foreign('friend_id')->references('id')->on('hunters')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friends');
    }
};
