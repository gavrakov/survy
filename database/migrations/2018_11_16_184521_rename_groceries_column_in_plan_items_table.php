<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameGroceriesColumnInPlanItemsTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('plan_item_list', function (Blueprint $table) {
            $table->dropForeign('plan_item_list_groceries_foreign');
            $table->dropColumn('groceries');
            $table->integer('grocery_id')->unsigned()->nullable();
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
        Schema::table('plan_item_list', function (Blueprint $table) {
            $table->dropForeign('plan_item_list_grocery_id_foreign');
            $table->dropColumn('grocery_id');
            $table->integer('groceries')->unsigned();
            $table->foreign('groceries')->references('id')->on('groceries')->onDelete('cascade');
        });
    }
}
