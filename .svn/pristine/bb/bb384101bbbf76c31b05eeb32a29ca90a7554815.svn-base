<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocationToThePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('plans', function (Blueprint $table) {
            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade');
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
        $table->dropForeign('plans_country_id_foreign');
        $table->dropColumn('country_id');
    }
}
