<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionalQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_questions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('birthdate')->nullable();
            $table->string('birthplace')->nullable();
            $table->integer('age')->nullable();
            $table->string('birthtime')->nullable();
            $table->string('checkbirthtime')->nullable();
            $table->string('topikasmara')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('durasikerja')->nullable();
            $table->string('durasihub')->nullable();
            $table->string('orientasi')->nullable();
            $table->string('masalahcinta')->nullable();
            $table->text('sisi_samping')->nullable();
            $table->text('telapak_jari')->nullable();
            $table->text('telapak_close')->nullable();
            $table->text('muka')->nullable();
            $table->unsignedBigInteger('sales_id');
            $table->foreign('sales_id')->references('id')->on('sales')->onDelete('restrict');
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
        Schema::dropIfExists('additional_questions');
    }
}
