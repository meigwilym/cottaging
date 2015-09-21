<?php

/**
 * Image
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class Image extends Eloquent {

  protected $hidden = array('deleted_at', 'created_at', 'updated_at');
  
  protected $fillable = array('cottage_id', 'fullpath', 'order_val');

  public function cottages()
  {
    return $this->belongsTo('Cottage', 'cottage_id');
  }

}

