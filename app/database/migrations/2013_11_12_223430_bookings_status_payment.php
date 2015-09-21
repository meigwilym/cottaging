<?php

use Illuminate\Database\Migrations\Migration;

class BookingsStatusPayment extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function($table){
            $table->string('status');
            $table->integer('amount');
            $table->integer('paid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function($table){
            $table->dropColumn('status', 'amount', 'paid');
        });
    }

}