<?php

// booking confirmed
Event::listen('booking.confirm', function($booking)
{
  $data = new \stdClass();
  $data->id = $booking->id;
  $data->email = $booking->user->email;
  $data->name = $booking->user->first_name.' '.$booking->user->last_name;
  $data->accom = $booking->cottage->name;
  $data->arrive = $booking->first_night->format('d/m/Y');
  $data->depart = $booking->last_night->format('d/m/Y');
  
  // send an email to the client
  /*
  Mail::send('emails.welcome', $data, function($message)
  {
      $message->from(Config::get('cottaging.admin-email'), Config::get('cottaging.site-name'));
      $message->to($email, $data->name)->subject('Booking Confirmation');
  });
  
  // email admins
  Mail::send('emails.newbooking', $data, function($msg){
    $msg->from(Config::get('cottaging.admin-email'), Config::get('cottaging.site-name'));
    $msg->to(Config::get('cottaging.admin-email'))->subject('New booking');
  });
  */
});
