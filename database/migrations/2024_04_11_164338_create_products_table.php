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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('secondary_name')->nullable();
            $table->string('slug')->nullable();
            $table->string('model')->nullable();
            $table->string('bar_code')->nullable();
            $table->string('internal_code')->nullable();
            $table->date('due_date')->nullable();
            $table->string('image_url')->nullable();
            $table->string('description')->nullable();
            $table->integer('stock_initial');
            $table->integer('stock_final')->nullable();
            $table->integer('unity_price');

            $table->foreignId('affectation_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('brand_id')->constrained();
            $table->foreignId('currency_id')->constrained();
            $table->foreignId('unit_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
