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
        Schema::create('graphics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('auto_name');
            $table->string('model')->nullable();
            $table->string('clock')->nullable();
            $table->string('memory_capacity')->nullable();
            $table->string('image_url')->nullable();
            $table->string('specifications_url')->nullable();

            $table->foreignId('memory_type_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graphics');
    }
};
