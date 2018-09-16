<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipeGroceriesRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_groceries_relation', function (Blueprint $table) {
            
            $table->integer('recipe_id')->unsigned();
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->integer('grocery_id')->unsigned();
            $table->foreign('grocery_id')->references('id')->on('recipes_category')->onDelete('cascade');
            $table->decimal('quantity',6,2);
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
        Schema::dropIfExists('recipe_groceries_relation');
    }
}
