<?php

use Illuminate\Database\Migrations\Migration;

class SlugAreas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('areas', function($table)
        {
          $table->string('slug')->after('area');
          $table->integer('parent_id')->after('id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('areas', function($table)
        {
          $table->dropColumn('slug', 'parent_id');
        });
	}

}