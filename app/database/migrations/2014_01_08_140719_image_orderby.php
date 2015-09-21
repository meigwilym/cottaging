<?php

use Illuminate\Database\Migrations\Migration;

class ImageOrderby extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('images', function($table)
        {
          $table->integer('order_val');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('images', function($table)
        {
          $table->dropColumn('order_val');
        });
	}

}