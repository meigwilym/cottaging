<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
                
        $this->call('AreaSeeder');
        $this->command->info('areas seeded');
        
        $this->call('CottageSeeder');
        $this->command->info('cottages seeded');
        
        $this->call('CottageAreaSeeder');
        $this->command->info('cottage_area seeded');
        
        $this->call('ImageSeeder');
        $this->command->info('images seeded');
        
        $this->call('SentrySeeder');
        $this->command->info('Sentry tables seeded!');
        
        $this->call('BookingSeeder');
        $this->command->info('bookings seeded');
        
        $this->call('FeaturesTableSeeder');
        $this->call('CottageFeaturesTableSeeder');
        $this->call('PricesTableSeeder');
	}

}
