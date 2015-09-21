<?php
namespace Cottaging\Repo\Price;

/**
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
interface PriceInterface {
  
  public function create(array $data);
  
  public function update($id, array $data);
  
  public function byCottage($cottage_id);
  
  public function calculateByNight($cottage_id, $start, $end);
  
  public function calculateByWeek($cottage_id, $start);
  
  public function getMinMax($cottage_id);
  
  public function destroyAllByCottage($cottage_id);
  
}
