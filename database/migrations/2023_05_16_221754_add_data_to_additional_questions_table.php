<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataToAdditionalQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('additional_questions', function (Blueprint $table) {
            $table->string('gender')->nullable();
            $table->text('nama_orang')->nullable();
            $table->string('siapa_dia')->nullable();
            $table->longText('kepribadian')->nullable();
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
