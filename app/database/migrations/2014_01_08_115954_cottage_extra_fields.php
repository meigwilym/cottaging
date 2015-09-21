<?php

use Illuminate\Database\Migrations\Migration;

class CottageExtraFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cottages', function($table)
        {
          $table->string('summary');
          $table->string('page_title');
          $table->string('keywords');
          $table->string('accommodation');
          $table->string('lat');
          $table->string('lon');
          
          $table->integer('sleeps');
          $table->integer('bedrooms');
          $table->integer('bathrooms');
          
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
          $table->dropColumn('summary', 'page_title', 'keywords', 'accommodation', 'lat', 'lon', 'sleeps', 'bedrooms', 'bathrooms');
        });
	}

}