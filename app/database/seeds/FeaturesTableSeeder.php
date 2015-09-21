<?php

class FeaturesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('features')->truncate();

		$features = array(
            array('name' => 'WiFi'),
            array('name' => 'Off Road Parking'),
            array('name' => 'Open Fire'),
            array('name' => 'Smoke Free'),
            array('name' => 'Garden & Patio'),
            array('name' => 'Washing Machine'),
            array('name' => 'Tumble Dryer'),
            array('name' => 'Washer/Dryer'),
            array('name' => 'Ground Floor Bedrooms'),
            array('name' => 'Dishwasher'),
            array('name' => 'Pub within 1 mile'),
            array('name' => 'Shop within 1 mile'),
            array('name' => 'Cot'),
            array('name' => 'Highchair'),
            array('name' => 'Hot Tub'),
		);

		// Uncomment the below to run the seeder
		DB::table('features')->insert($features);
	}

}
