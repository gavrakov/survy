<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnRecipeIdInRecipeCategoriesRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('recipe_categories_relation', function (Blueprint $table) {
            $table->dropForeign('recipe_categories_relation_recipe_id_foreign');
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
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
        Schema::table('recipe_categories_relation', function (Blueprint $table) {
            $table->dropForeign('recipe_id');
            $table->foreign('recipe_id')->references('id')->on('recipes')->onUpdate('cascade');
        });
    }
}
