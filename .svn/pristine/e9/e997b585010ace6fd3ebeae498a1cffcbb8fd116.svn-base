<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdColumnToTheRecipeGroceriesRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         //
        Schema::table('recipe_groceries_relation', function (Blueprint $table) {
             $table->increments('id');
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
         Schema::table('recipe_groceries_relation', function (Blueprint $table) {
             $table->dropColumn('id');
        });
    }
}
