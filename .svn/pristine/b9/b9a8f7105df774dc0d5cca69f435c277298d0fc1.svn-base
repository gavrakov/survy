<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroceriesUniteTable extends Migration
{
    /**
     * Create groceries_unite table.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groceries_unite', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('unite');
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
        Schema::dropIfExists('groceries_unite');
    }
}
