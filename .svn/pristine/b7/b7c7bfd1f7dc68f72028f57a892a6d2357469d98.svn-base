<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipeCategoriesRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_categories_relation', function (Blueprint $table) {
            //$table->increments('id');
            $table->integer('recipe_id')->unsigned();
            $table->foreign('recipe_id')->references('id')->on('recipes')->onUpdate('cascade');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('recipes_category')->onUpdate('cascade');
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
        Schema::dropIfExists('recipe_categories_realation');
    }
}
