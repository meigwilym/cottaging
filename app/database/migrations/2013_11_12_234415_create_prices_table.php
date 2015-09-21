<?php

use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function($table)
        {
            $table->increments('id');
            $table->integer('cottage_id');
            $table->date('start');
            $table->date('end');
            $table->integer('price');
            
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
        Schema::drop('prices');
    }

}