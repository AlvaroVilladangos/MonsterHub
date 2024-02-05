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
        Schema::create('comments', function (Blueprint $table) {
            $table -> id();
            $table -> unsignedBigInteger('from_id');
            $table -> unsignedBigInteger('to_id');
            $table -> string('msg');

            $table->foreign('from_id')->references('id')->on('hunters')->onDelete('cascade');;
            $table->foreign('to_id')->references('id')->on('hunters')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
