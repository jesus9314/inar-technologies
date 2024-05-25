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
        Schema::create('graphic_graphic_sufix', function (Blueprint $table) {
            $table->id();

            $table->foreignId('graphic_id')->constrained();
            $table->foreignId('graphic_sufix_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graphic_graphic_sufix');
    }
};
