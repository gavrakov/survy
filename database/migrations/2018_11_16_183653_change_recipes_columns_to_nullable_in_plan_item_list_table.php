<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRecipesColumnsToNullableInPlanItemListTable extends Migration
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
            $table->integer('breakfast')->unsigned()->nullable()->change();
            $table->integer('lunch')->unsigned()->nullable()->change();
            $table->integer('dinner')->unsigned()->nullable()->change();
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
            $table->integer('breakfast')->unsigned()->nullable(false)->change();
            $table->integer('lunch')->unsigned()->nullable(false)->change();
            $table->integer('dinner')->unsigned()->nullable(false)->change();
        });
    }
}
