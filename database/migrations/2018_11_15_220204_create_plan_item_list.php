<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanItemList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('plan_item_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('plan_items')->onDelete('cascade');
            $table->integer('breakfast')->unsigned();
            $table->foreign('breakfast')->references('id')->on('recipes')->onDelete('cascade');
            $table->integer('lunch')->unsigned();
            $table->foreign('lunch')->references('id')->on('recipes')->onDelete('cascade');
            $table->integer('dinner')->unsigned();
            $table->foreign('dinner')->references('id')->on('recipes')->onDelete('cascade');
            $table->integer('groceries')->unsigned();
            $table->foreign('groceries')->references('id')->on('groceries')->onDelete('cascade');
            $table->decimal('quantity',6,2);
            $table->decimal('price',9,3);
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
        //
        Schema::dropIfExists('plan_item_list');
    }
}
