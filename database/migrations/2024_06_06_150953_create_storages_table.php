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
        Schema::create('storages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->boolean('auto_name');
            $table->string('type')->nullable(); // SSD o HDD
            $table->string('model')->nullable();
            $table->string('capacity')->nullable(); // e.g., 500GB, 1TB
            $table->string('interface')->nullable(); // e.g., SATA, NVMe
            $table->string('form_factor')->nullable(); // e.g., 2.5", 3.5", M.2
            $table->integer('read_speed')->nullable(); // Opcional, para SSD
            $table->integer('write_speed')->nullable(); // Opcional, para SSD
            $table->string('specs_link')->nullable();

            $table->foreignId('brand_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storages');
    }
};
