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
        Schema::create('peripherals', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('image_url');

            $table->foreignId('brand_id')->constrained();
            $table->foreignId('peripheral_type_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peripherals');
    }
};
