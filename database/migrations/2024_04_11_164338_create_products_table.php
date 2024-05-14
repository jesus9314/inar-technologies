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
            $table->string('name')->unique()->nullable();
            $table->string('slug')->nullable()->unique();
            $table->string('secondary_name')->nullable();
            $table->string('model')->nullable();
            $table->string('bar_code')->nullable();
            $table->string('internal_code')->nullable();
            $table->date('due_date')->nullable();
            $table->string('image_url')->nullable();
            $table->string('description')->nullable();
            $table->integer('stock_initial')->nullable();
            $table->integer('stock_final')->nullable();
            $table->integer('stock_min')->nullable();
            $table->integer('unity_price');

            $table->foreignId('affectation_id')->nullable()->constrained();
            $table->foreignId('category_id')->nullable()->constrained();
            $table->foreignId('brand_id')->nullable()->constrained();
            $table->foreignId('currency_id')->nullable()->constrained();
            $table->foreignId('unit_id')->nullable()->constrained();

            $table->softDeletes();
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
