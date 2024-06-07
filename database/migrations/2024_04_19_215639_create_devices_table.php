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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug');
            $table->string('identifier')->nullable();
            $table->text('description')->nullable();
            $table->text('aditional_info')->nullable();
            $table->float('ram_total')->nullable();
            $table->string('speccy_snapshot_url')->nullable();

            $table->foreignId('device_state_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('processor_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('device_type_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
