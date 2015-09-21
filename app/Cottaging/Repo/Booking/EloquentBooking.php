<?php

namespace Cottaging\Repo\Booking;

use Cottaging\Repo\Booking;

use Sentry;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Description of EloquentBooking
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class EloquentBooking implements BookingInterface{
    
    protected $booking;
    
    public function __construct(Model $booking)
    {
        $this->booking = $booking;
    }
    
    /**
     * Get details for a single booking
     * 
     * @param type $id
     */
    public function byId($id)
    {
      return $this->booking->with('cottage.areas', 'user')
              ->find($id);
    }
    
    /**
     * Return booked dates for this month onwards
     * 
     * @param int $cottage_id cottage id
     * @return recordset
     */
    public function byCottage($cottage_id, $from = 'now')
    {
        $d = new Carbon($from);
        $time = $d->toDateString();
        
        return $this->booking
                    ->where('cottage_id', '=', $cottage_id)
                    ->where('last_night', '>=', $time)
                    ->where('status', '=', 'COMPLETE')
                    ->orderBy('first_night')
                    ->get();
    }
    
    /**
     * Save a booking 
     * 
     * @param array $input
     * @return boolean
     */
    public function create(array $input)
    {
      $booking = $this->booking->create($input);
      
      if(!$booking) return false;
      
      return $booking->id;
    }
    
    
    public function update($id, array $data)
    {
      $booking = $this->booking->update($input);
      
      if(!$booking) return false;
      
      return $booking->id;
    }
    
    /**
     * All active bookings 
     */
    public function allActive()
    {
      $now = Carbon::now()->toDateString();
      
      return $this->booking->with('cottage')->where('first_night', '<=', $now)
            ->where('last_night', '>=', $now)
            ->where('status', '=', 'COMPLETE')
            ->get();
    }
    
    /**
     * All future bookings
     */
    public function allFuture()
    {
      $now = Carbon::now()->toDateString();
      
      return $this->booking->with('cottage')
              ->where('first_night', '>', $now)
              ->where('status', '=', 'COMPLETE')
              ->orderBy('first_night')
              ->get();
    }
    
    /**
     * Historical bookings
     */
    public function allPast()
    {
      $now = Carbon::now()->toDateString();
      
      return $this->booking->with('cottage')
              ->where('last_night', '<', $now)
              ->where('status', '=', 'COMPLETE')
              ->orderBy('last_night', 'DESC')
              ->get();
    }
    
    /**
     * Recently made bookings
     * i.e. in the past week
     */
    public function recent()
    {
      $week = Carbon::now()->subWeek()->toDateTimeString();
      
      return $this->booking->with('cottage')
              ->where('created_at', '>', $week)
              ->where('status', '=', 'COMPLETE')
              ->orderBy('created_at')
              ->get();
    }
    
}

