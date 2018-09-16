<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropCategoryColumnFromRecipesTable extends Migration
{
    /**
     * Droping column category.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropForeign('recipes_category_foreign'); 
            $table->dropColumn('category');
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
             $table->integer('category')->unsigned();
        });
    }
}
