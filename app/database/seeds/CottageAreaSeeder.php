<?php

/**
 * Description of CottageAreaSeeder
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class CottageAreaSeeder extends Illuminate\Database\Seeder{
  
  public function run()
  {
    DB::table('cottage_area')->delete();
    
    // attach to areas
    $cottage = Cottage::find(1);
    $cottage->areas()->attach(1);
    $cottage->areas()->attach(2);
    $cottage->areas()->attach(3);
    
    $cottage = Cottage::find(2);
    $cottage->areas()->attach(1);
    $cottage->areas()->attach(2);
    $cottage->areas()->attach(4);
  }
}

