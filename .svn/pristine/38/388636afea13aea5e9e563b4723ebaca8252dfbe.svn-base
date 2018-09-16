<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePlanItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('plan_items', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('plan_id')->unsigned();
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->integer('breakfast')->unsigned();
            $table->foreign('breakfast')->references('id')->on('recipes')->onDelete('cascade');
            $table->integer('lunch')->unsigned();
            $table->foreign('lunch')->references('id')->on('recipes')->onDelete('cascade');
            $table->integer('dinner')->unsigned();
            $table->foreign('dinner')->references('id')->on('recipes')->onDelete('cascade');
            $table->integer('groceries')->unsigned();
            $table->foreign('groceries')->references('id')->on('groceries')->onDelete('cascade');
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
        Schema::dropIfExists('plan_items');
    }
}
