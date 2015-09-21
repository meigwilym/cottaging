<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPerNightToPrices extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('prices', function(Blueprint $table) {
          $table->integer('night_price');
          $table->integer('week_price');
          $table->dropColumn('price');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('prices', function(Blueprint $table) {
          $table->integer('price');
          $table->dropColumn('night_price', 'week_price');
		});
	}

}
