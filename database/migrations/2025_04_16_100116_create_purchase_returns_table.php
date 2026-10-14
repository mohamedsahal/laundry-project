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
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('supplier_id')->nullable();
            $table->string('supplier_name')->nullable();
            $table->integer('purchase_id')->nullable();
            $table->string('purchase_number');
            $table->string('invoice_number');
            $table->date('invoice_date')->nullable();
            $table->string('purchase_return_number')->nullable();
            $table->double('discount', 20, 3)->nullable();
            $table->double('discount_total', 20, 3)->nullable();
            $table->double('sub_total', 20, 3);
            $table->double('tax_amount', 15, 3)->nullable();
            $table->double('taxable_amount', 20, 3)->nullable();
            $table->double('total', 20, 3);
            $table->integer('status')->nullable();
            $table->text('notes')->nullable();
            $table->text('reason')->nullable();
            $table->integer('total_quantity')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('financial_year_id')->nullable();
            $table->integer('payment_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_returns');
    }
};
