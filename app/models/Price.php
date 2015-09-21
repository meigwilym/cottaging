<?php
/**
 * Fetch prices for a cottage at different times of the year
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class Price extends Eloquent {
    
    protected $fillable = array(
        'cottage_id',
        'start',
        'end',
        'night_price'
    );
    
    public function cottage()
    {
        return $this->belongsTo('cottage');
    }
}

