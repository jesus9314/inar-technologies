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
        Schema::create('processors', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->string('generation')->nullable();
            $table->string('cores')->nullable();
            $table->string('socket')->nullable();
            $table->string('tdp')->nullable();
            $table->string('integrated_graphics')->nullable();
            $table->string('memory_capacity')->nullable();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('specifications_url')->nullable();

            $table->foreignId('brand_id')->constrained();
            $table->foreignId('processor_condition_id')->constrained();
            $table->foreignId('memory_type_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processors');
    }
};
