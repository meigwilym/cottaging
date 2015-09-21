<?php

use Illuminate\Database\Migrations\Migration;

class StartdaymindurCottages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cottages', function($table)
        {
          $table->string('start_days');
          $table->integer('min_duration');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cottages', function($table)
        {
          $table->dropColumn('start_days', 'min_duration');
        });
	}

}