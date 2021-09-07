<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShippingToSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->text('ship_address')->nullable();
            $table->text('ship_province')->nullable();
            $table->text('ship_city')->nullable();
            $table->text('ship_zip')->nullable();
            $table->integer('ship_cost')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('ship_address');
            $table->dropColumn('ship_province');
            $table->dropColumn('ship_city');
            $table->dropColumn('ship_zip');
            $table->dropColumn('ship_cost');
        });
    }
}
