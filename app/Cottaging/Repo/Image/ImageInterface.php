<?php

namespace Cottaging\Repo\Image;

/**
 * Description of ImageInterface
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
interface ImageInterface {
  
  public function create(array $data);
  
  public function update($id, array $data);
  
  public function byCottage($cottage_id);
  
  public function setOrderVal($id, $order);
  
  public function destroy($id);
  
}
