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
        Schema::create('purchase_return_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('purchase_return_id');
            $table->integer('product_id');
            $table->integer('type');
            $table->string('product_name');
            $table->double('quantity',20,3);
            $table->double('rate',20,3);
            $table->double('tax_percentage',20,3);
            $table->double('discount',20,3)->nullable();
            $table->double('tax_amount',20,3);
            $table->double('total',20,3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_return_details');
    }
};
