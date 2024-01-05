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
            $table->unsignedBigInteger('hunter_1');
            $table->unsignedBigInteger('hunter_2');
            $table->unsignedBigInteger('requester_id');
            $table->string('status');
    
            $table->foreign('hunter_1')->references('id')->on('hunters')
                ->onDelete('cascade');
            $table->foreign('hunter_2')->references('id')->on('hunters')
                ->onDelete('cascade');
            $table->foreign('requester_id')->references('id')->on('hunters')
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
