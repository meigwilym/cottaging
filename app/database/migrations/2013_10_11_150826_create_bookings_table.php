<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function(Blueprint $table)
                {
                    $table->increments('id');
                    $table->integer('cottage_id');
                    $table->integer('client_id');
                    $table->integer('nights');
                    $table->date('first_night');
                    $table->date('last_night');

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
        Schema::drop('bookings');
    }

}
