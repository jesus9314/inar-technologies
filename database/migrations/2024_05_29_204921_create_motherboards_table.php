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
        Schema::create('motherboards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->boolean('auto_name');
            $table->string('model')->nullable();
            $table->string('form_factor')->nullable();
            $table->string('socket')->nullable();
            $table->string('chipset')->nullable();
            $table->string('expansion_slots')->nullable();
            $table->string('io_ports')->nullable();
            $table->string('features')->nullable();
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
        Schema::dropIfExists('mother_boards');
    }
};
