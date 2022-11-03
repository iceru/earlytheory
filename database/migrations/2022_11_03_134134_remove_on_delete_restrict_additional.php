<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveOnDeleteRestrictAdditional extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('additional_questions', function (Blueprint $table) {
            $table->dropForeign('sales_id');
            $table
            ->foreign('sales_id')
            ->references('id')
            ->on('sales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('additional_questions', function (Blueprint $table) {
            //
        });
    }
}
