<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->dateTime('order_date')->nullable();
            $table->dateTime('delivery_date')->nullable();
            $table->double('sub_total',15,2)->default(0);
            $table->double('addon_total',15,2)->default(0);
            $table->double('discount',15,2)->default(0);
            $table->double('tax_percentage',15,2)->default(0);
            $table->double('tax_amount',15,2)->default(0);
            $table->double('total',15,2)->default(0);
            $table->longText('note')->nullable();
            $table->integer('status')->default(0);
            $table->integer('order_type')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('financial_year_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
