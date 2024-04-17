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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();

            $table->date('date_of_issue');
            $table->date('date_of_reception');

            $table->float('price')->nullable();
            $table->float('igv')->nullable();
            $table->float('total_price')->nullable();

            $table->string('series');
            $table->string('number');

            $table->foreignId('tax_document_type_id')->constrained();
            $table->foreignId('supplier_id')->constrained();
            $table->foreignId('currency_id')->constrained();
            $table->foreignId('action_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
