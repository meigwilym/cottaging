<?php

/**
 * Description of AreaSeeder
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class AreaSeeder extends Illuminate\Database\Seeder{
  
  public function run()
  {
    DB::table('areas')->delete();
    
    Area::create(array(
        'parent_id' => '0',
        'area' => 'Wales',
        'slug' => 'wales',
        'description' => 'Country in UK',
    ));
    Area::create(array(
        'parent_id' => '1',
        'area' => 'Gwynedd',
        'slug' => 'gwynedd',
        'description' => 'County in Wales',
    ));
    Area::create(array(
        'parent_id' => '2',
        'area' => 'Y Felinheli',
        'slug' => 'y-felinheli',
        'description' => 'Village in Gwynedd',
    ));
    Area::create(array(
        'parent_id' => '2',
        'area' => 'Caernarfon',
        'slug' => 'caernarfon',
        'description' => 'Town in Gwynedd',
    ));
    Area::create(array(
        'parent_id' => '1',
        'area' => 'Anglesey',
        'slug' => 'anglesey',
        'description' => 'County in Wales',
    ));
    Area::create(array(
        'parent_id' => '5',
        'area' => 'Beaumaris',
        'slug' => 'beaumaris',
        'description' => 'Town in Anglesey',
    ));
  }
}

