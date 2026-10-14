<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddonId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_addon_details', function (Blueprint $table) {
            $table->unsignedBigInteger('addon_id')->nullable();
            $table->foreign('addon_id')->references('id')->on('addons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_addon_details', function (Blueprint $table) {
            $table->dropColumn('addon_id');
        });
    }
}