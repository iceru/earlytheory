<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->text('name')->nullable();
            $table->text('phone')->nullable();
            $table->unsignedBigInteger('paymethod_id')->nullable();
            $table->foreign('paymethod_id')->references('id')->on('payment_methods')->onDelete('cascade');
            $table->text('relationship')->nullable();
            $table->text('job')->nullable()-;
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
            $table->dropColumn('name');
            $table->dropColumn('phone');
            $table->dropColumn('paymethod_id');
            $table->dropIndex('paymethod_id');
            $table->dropColumn('relationship');
            $table->dropColumn('job');
        });
    }
}
