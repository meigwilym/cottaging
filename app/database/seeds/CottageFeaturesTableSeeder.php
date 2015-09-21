<?php

class CottageFeaturesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('cottage_feature')->truncate();

		$cottage_features = array(
            array('cottage_id' => '1', 'feature_id' => '1'),
            array('cottage_id' => '1', 'feature_id' => '3'),
            array('cottage_id' => '1', 'feature_id' => '5'),
            array('cottage_id' => '1', 'feature_id' => '7'),
            array('cottage_id' => '1', 'feature_id' => '9'),
            array('cottage_id' => '1', 'feature_id' => '11'),
            array('cottage_id' => '1', 'feature_id' => '13'),
            array('cottage_id' => '2', 'feature_id' => '2'),
            array('cottage_id' => '2', 'feature_id' => '4'),
            array('cottage_id' => '2', 'feature_id' => '6'),
            array('cottage_id' => '2', 'feature_id' => '8'),
            array('cottage_id' => '2', 'feature_id' => '10'),
            array('cottage_id' => '2', 'feature_id' => '12'),
            array('cottage_id' => '2', 'feature_id' => '14'),
		);

		// Uncomment the below to run the seeder
		DB::table('cottage_feature')->insert($cottage_features);
	}

}
