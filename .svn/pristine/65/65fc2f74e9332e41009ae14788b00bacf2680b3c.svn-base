<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrceriesCategoryTable extends Migration
{
    /**
     * Create groceries category table.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groceries_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
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
        Schema::dropIfExists('grceries_category');
    }
}
