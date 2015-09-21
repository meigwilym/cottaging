<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotCottageFeatureTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cottage_feature', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('cottage_id')->unsigned()->index();
			$table->integer('feature_id')->unsigned()->index();
			$table->foreign('cottage_id')->references('id')->on('cottages')->onDelete('cascade');
			$table->foreign('feature_id')->references('id')->on('features')->onDelete('cascade');
		});
	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cottage_feature');
	}

}
