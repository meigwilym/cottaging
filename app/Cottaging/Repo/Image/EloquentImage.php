<?php

namespace Cottaging\Repo\Image;


use Illuminate\Database\Eloquent\Model;

/**
 * Description of EloquentImage
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class EloquentImage implements ImageInterface {
  
  protected $image;

  public function __construct(Model $image)
  {
    $this->image = $image;
  }
  
  /**
   * Save a record
   * 
   * @param array $data
   * @return object|bool
   */
  public function create(array $data)
  {
    return $this->image->create(array(
        'cottage_id' => $data['cottage_id'],
        'fullpath' => $data['fullpath'],
        'order_val' => $data['order_val'],
    ));
  }
  
  /**
   * 
   * @param int $id
   * @param array $data
   */
  public function update($id, array $data)
  {
    ;
  }
  
  /**
   * Set the ordering value on an image
   * 
   * @param type $id
   * @param type $order
   * @return boolean
   */
  public function setOrderVal($id, $order)
  {
    $img = $this->image->find($id);
    if(!$img) return false;
    
    $img->order_val = $order;
    return $img->save();
  }
  
  /**
   * Get a cottage's images
   * 
   * @param int $cottage_id
   */
  public function byCottage($cottage_id)
  {
    ;
  }
  
  /**
   * Delete an image
   * Database and files deleted
   * 
   * @param int $id
   * @return bool
   */
  public function destroy($id)
  {
    $img = $this->image->findOrFail($id);
    
    \File::delete(public_path().'/media/'.$img->fullpath);
    \File::delete(public_path().'/media/original/'.$img->fullpath);
    \File::delete(public_path().'/media/thumb/'.$img->fullpath);
    
    return $img->delete();
  }
}
