<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddDefaultsToCottages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cottages', function(Blueprint $table) {
          $table->integer('dogs');
          $table->integer('night_price');
          $table->integer('week_price');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cottages', function(Blueprint $table) {
          $table->dropColumn('dogs', 'night_price', 'week_price');
		});
	}

}
