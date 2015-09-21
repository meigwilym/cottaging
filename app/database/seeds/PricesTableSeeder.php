<?php

class PricesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('prices')->truncate();

		$prices = array(
            // cottage 1
            array('cottage_id' => '1', 'start' => '2015-03-01', 'end' => '2015-05-31', 'night_price'=> '60', 'week_price' => '400'),
            array('cottage_id' => '1', 'start' => '2015-06-01', 'end' => '2015-09-30', 'night_price'=> '75', 'week_price' => '500'),
            // cottage 2
            array('cottage_id' => '2', 'start' => '2015-03-01', 'end' => '2015-05-31', 'night_price'=> '70', 'week_price' => '450'),
            array('cottage_id' => '2', 'start' => '2015-06-01', 'end' => '2015-09-30', 'night_price'=> '85', 'week_price' => '550'),
            array('cottage_id' => '2', 'start' => '2015-10-01', 'end' => '2015-12-31', 'night_price'=> '50', 'week_price' => '325'),
		);

		// Uncomment the below to run the seeder
		DB::table('prices')->insert($prices);
	}

}
