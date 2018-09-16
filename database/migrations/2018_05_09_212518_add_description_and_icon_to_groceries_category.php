<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionAndIconToGroceriesCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('groceries_category', function (Blueprint $table) {
            $table->text('description');
            $table->string('icon');
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
        Schema::table('groceries_category', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('icon');
        });
    }
}
