<?php

class Client extends Eloquent {

  public function bookings()
  {
    return $this->hasMany('bookings');
  }

  public function user()
  {
    return $this->belongsTo('users');
  }

}