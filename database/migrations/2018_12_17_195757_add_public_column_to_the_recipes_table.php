<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPublicColumnToTheRecipesTable extends Migration
{
    /**
     * Add public column to the recipes table. 
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('recipes', function (Blueprint $table) {
            $table->boolean('public');
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
         Schema::table('recipes', function (Blueprint $table) {
            $table->dropColumn('public');
        });
    }
}
