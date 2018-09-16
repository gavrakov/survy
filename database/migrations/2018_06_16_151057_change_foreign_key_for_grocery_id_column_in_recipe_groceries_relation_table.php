<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeForeignKeyForGroceryIdColumnInRecipeGroceriesRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('recipe_groceries_relation', function (Blueprint $table) {
            $table->dropForeign('recipe_groceries_relation_grocery_id_foreign');
            $table->foreign('grocery_id')->references('id')->on('groceries')->onDelete('cascade');
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
            $table->dropForeign('recipe_groceries_relation_grocery_id_foreign');
            $table->foreign('grocery_id')->references('id')->on('recipes_category')->onDelete('cascade');
        });
    }
}
