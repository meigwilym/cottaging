<?php

use Illuminate\Database\Migrations\Migration;


class UserDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
      if (Schema::hasTable('users'))
      {
        Schema::table('users', function($table)
        {
          $table->string('telephone');
          $table->string('address1');
          $table->string('address2');
          $table->string('town');
          $table->string('postcode');
        });
      }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{ 
      if (Schema::hasTable('users'))
      {
		Schema::table('users', function($table)
        {
          $table->dropColumn('telephone', 'address1', 'address2', 'town', 'postcode');
        });
      }
	}

}