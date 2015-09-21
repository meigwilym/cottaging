<?php

class Booking extends Eloquent {

  protected $guarded = array('id');
  
  protected $hidden = array('id', 'cottage_id', 'client_id', 'created_at', 'updated_at', 'amount', 'amount', 'paid');

  protected $appends = array('depart');
  
  /**
   * Validation rules
   * @var array
   */
  protected $rules = array();
  
  /**
   * Return the first night as a Carbon instance
   * 
   * @return object
   */
  public function getFirstNightAttribute()
  {
    return Carbon::parse($this->attributes['first_night']); 
  }
  
  /**
   * Return a Carbon instance
   * 
   * @return object
   */
  public function getLastNightAttribute()
  {
    return Carbon::parse($this->attributes['last_night']);
  }
  
  /**
   * Add 1 day to the last_night for the departure date
   * 
   * @return object
   */
  public function getDepartAttribute()
  {
    return $this->last_night->copy()->addDay();
  }
  
  /**
   * One to one with Cottage
   * 
   * @return Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function cottage()
  {
    return $this->belongsTo('Cottage');
  }

  /**
   * One to one (child) with users
   * 
   * @return Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo('User', 'client_id', 'id');
  }

}