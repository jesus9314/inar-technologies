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
        Schema::create('rams', function (Blueprint $table) {
            $table->id();
            $table->string('speed');
            $table->string('capacity');
            $table->string('latency')->nullable();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('specifications_link')->nullable();

            $table->foreignId('brand_id')->constrained();
            $table->foreignId('ram_form_factor_id')->constrained();
            $table->foreignId('memory_type_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rams');
    }
};
