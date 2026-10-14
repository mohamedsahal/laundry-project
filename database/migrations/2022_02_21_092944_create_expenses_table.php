<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('expense_date');
            $table->unsignedBigInteger('expense_category_id')->nullable();
            $table->foreign('expense_category_id')->references('id')->on('expense_categories');
            $table->double('expense_amount',15,2);
            $table->integer('payment_mode')->nullable();
            $table->integer('tax_included');
            $table->double('tax_percentage',6,2)->nullable();
            $table->longText('note')->nullable();
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
        Schema::dropIfExists('expenses');
    }
}
