<?php

/**
 * Description of CottageSeeder
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class CottageSeeder extends Seeder {
  
  public function run()
  {
    DB::table('cottages')->delete();
    
    Cottage::create(array(
        'name' => 'Test Cottage 1',
        'slug' => 'test-cottage-1',
        'description' => 'House in Caernarfon',
        'start_days' => [6,3], // sat wed
        'min_duration' => '3',
        'summary' => 'A lovely house in Caernarfon',
        'page_title' => '1 test holiday cottage, Caernarfon, Gwynedd, Wales',
        'keywords' => 'holiday cottage, caernarfon, holiday let',
        'accommodation' => 'House has 5 bedrooms and 1 bathroom',
        'lat' => '53.139551',
        'lon' => '-4.273911',
        'sleeps' => '8',
        'bedrooms' => '5',
        'bathrooms' => '1',
        'dogs' => '0',
        'night_price' => '45',
        'week_price' => '300',
    ));
    
    Cottage::create(array(
        'name' => 'Test Cottage 2',
        'slug' => 'test-cottage-2',
        'description' => 'Farmhouse in Aberdaron',
        'start_days' => [6], // sat
        'min_duration' => '7',
        'summary' => 'A renovated farmhouse with stunning views of the Irish Sea',
        'page_title' => '2nd Test holiday cottage, Aberdaron, Gwynedd, Wales',
        'keywords' => 'holiday cottage, aberdaron, holiday let',
        'accommodation' => 'Away from the road, the accommodation has 4 bedrooms and 3 bathrooms',
        'lat' => '52.804729',
        'lon' => '-4.711515',
        'sleeps' => '6',
        'bedrooms' => '4',
        'bathrooms' => '3',
        'dogs' => '2',
        'night_price' => '55',
        'week_price' => '350',
    ));
  }
}

