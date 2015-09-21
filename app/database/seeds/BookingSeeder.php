<?php

/**
 * Description of BookingSeeder
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class BookingSeeder extends Illuminate\Database\Seeder{
  
  public function run()
  {
    DB::table('bookings')->delete();
    
    Booking::create(array(
        'cottage_id' => '1',
        'client_id' => '2',
        'nights' => '3',
        'first_night' => '2015-08-03',
        'last_night' => '2015-08-10',
        'status' => 'COMPLETE',
        'amount' => '',
        'paid' => '',
    ));
    
    Booking::create(array(
        'cottage_id' => '1',
        'client_id' => '2',
        'nights' => '3',
        'first_night' => '2016-01-11',
        'last_night' => '2016-01-13',
        'status' => 'COMPLETE',
        'amount' => '',
        'paid' => '',
    ));
    
    Booking::create(array(
        'cottage_id' => '1',
        'client_id' => '3',
        'nights' => '7',
        'first_night' => '2016-01-18',
        'last_night' => '2016-01-24',
        'status' => 'COMPLETE',
        'amount' => '',
        'paid' => '',
    ));
    
    Booking::create(array(
        'cottage_id' => '1',
        'client_id' => '4',
        'nights' => '7',
        'first_night' => '2016-01-25',
        'last_night' => '2016-01-31',
        'status' => 'COMPLETE',
        'amount' => '',
        'paid' => '',
    ));
    
    Booking::create(array(
        'cottage_id' => '1',
        'client_id' => '4',
        'nights' => '5',
        'first_night' => '2016-02-05',
        'last_night' => '2016-02-09',
        'status' => 'COMPLETE',
        'amount' => '',
        'paid' => '',
    ));
    
    Booking::create(array(
        'cottage_id' => '1',
        'client_id' => '5',
        'nights' => '7',
        'first_night' => '2016-02-15',
        'last_night' => '2016-02-21',
        'status' => 'COMPLETE',
        'amount' => '',
        'paid' => '',
    ));
    
    Booking::create(array(
        'cottage_id' => '2',
        'client_id' => '3',
        'nights' => '14',
        'first_night' => '2016-01-25',
        'last_night' => '2016-02-07',
        'status' => 'COMPLETE',
        'amount' => '',
        'paid' => '',
    ));
    
    Booking::create(array(
        'cottage_id' => '2',
        'client_id' => '5',
        'nights' => '7',
        'first_night' => '2016-02-08',
        'last_night' => '2016-02-14',
        'status' => 'COMPLETE',
        'amount' => '',
        'paid' => '',
    ));
  }
}

