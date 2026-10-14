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
        Schema::create('stock_usages', function (Blueprint $table) {
            $table->id();
            $table->date('usage_date');
            $table->foreignId('product_id')->constrained('products');
            $table->double('quantity');
            $table->double('unit_cost')->default(0);
            $table->double('total_cost')->default(0);
            $table->longText('note')->nullable();
            $table->unsignedBigInteger('financial_year_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_usages');
    }
};
