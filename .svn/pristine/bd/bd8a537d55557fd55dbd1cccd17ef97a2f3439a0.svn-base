<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRecipesCategoryColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Cahanging category column
        Schema::table('recipes', function (Blueprint $table) {
        $table->foreign('category')->references('id')->on('recipes_category')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('recipes', function (Blueprint $table) {
            $table->integer('category')->unsigned();
        });
    }
}
