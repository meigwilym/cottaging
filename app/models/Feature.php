<?php

class Feature extends Eloquent {
  
	protected $guarded = array();

	public static $rules = array();
    
    public function cottages()
    {
      return $this->belongsToMany('Cottage');
    }
}
