<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropQuantityFromGroceriesPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('groceries_prices', function (Blueprint $table) {  
            $table->dropColumn('quantity');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
         Schema::table('groceries_prices', function (Blueprint $table) {  
            $table->decimal('quantity',6,2);
        });
    }
}
