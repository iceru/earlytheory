<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkuvaluesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skuvalues', function (Blueprint $table) {
            $table->unsignedBigInteger('sku_id');
            $table->foreign('sku_id')->references('id')->on('skus')->onDelete('cascade');
            $table->unsignedBigInteger('option_id');
            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
            $table->unsignedBigInteger('value_id');
            $table->foreign('value_id')->references('id')->on('optionvalues')->onDelete('cascade');
            $table->primary(['sku_id', 'option_id', 'value_id']);
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
        Schema::dropIfExists('skuvalues');
    }
}
