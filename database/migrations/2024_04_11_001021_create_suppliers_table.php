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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('comercial_name');
            
            $table->foreignId('document_id')->constrained();
            $table->string('document_number');

            $table->string('phone_number')->nullable();
            $table->string('image_url')->nullable();
            $table->string('web')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('supplier_type_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
