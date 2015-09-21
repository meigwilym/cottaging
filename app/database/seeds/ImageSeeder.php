<?php

/**
 * Description of ImageSeeder
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class ImageSeeder extends Illuminate\Database\Seeder{
  
  public function run()
  {
    DB::table('images')->delete();
    
    Image::create(array(
        'cottage_id' => '2',
        'fullpath' => 'IMG_0096.JPG',
        'order_val' => '2',
    ));
    Image::create(array(
        'cottage_id' => '2',
        'fullpath' => 'IMG_0099.JPG',
        'order_val' => '3',
    ));
    Image::create(array(
        'cottage_id' => '2',
        'fullpath' => 'IMG_0100.JPG',
        'order_val' => '1',
    ));
    Image::create(array(
        'cottage_id' => '2',
        'fullpath' => 'IMG_0102.JPG',
        'order_val' => '4',
    ));
    
  }
}

