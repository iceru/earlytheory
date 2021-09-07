<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('phone');
            $table->text('birthdate')->nullable();
            $table->text('relationship')->nullable();
            $table->text('job')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropColumn('phone');
        $table->dropColumn('birthdate');
        $table->dropColumn('relationship');
        $table->dropColumn('job');
    }
}
