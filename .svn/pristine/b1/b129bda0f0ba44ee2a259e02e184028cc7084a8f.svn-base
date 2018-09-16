<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeGroceriesUniteColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // change groceries unite column.
        Schema::table('groceries', function (Blueprint $table) {
            $table->integer('unite')->unsigned()->change();
            $table->foreign('unite')->references('id')->on('groceries_unite')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
