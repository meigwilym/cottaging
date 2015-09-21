<?php


class Area extends Eloquent {
    
    protected $fillable = array(
        'area',
        'description'
    );
    
    public function cottages()
    {
        // return $this->belongsToMany('cottage', 'cottage_area');
    }
}