<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroceriesPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groceries_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('grocery_id')->unsigned();
            $table->foreign('grocery_id')->references('id')->on('groceries')->onUpdate('cascade');
            $table->decimal('quantity',6,2);
            $table->decimal('price',9,3);
            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade');
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
        Schema::dropIfExists('groceries_prices');
    }
}
