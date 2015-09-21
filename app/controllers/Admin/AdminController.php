<?php

namespace Admin;

use View;

use Cottaging\Repo\Booking\BookingInterface;
use Cottaging\Repo\Cottage\CottageInterface;


/**
 * Description of AdminController
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class AdminController extends \BaseController {
  
  protected $booking;
  
  protected $cottage;
  
  public function __construct(BookingInterface $booking, CottageInterface $cottage)
  {
    $this->booking = $booking;
    $this->cottage = $cottage;
  }
  
  /**
   * Admin home
   *  - recent bookings (in past week)
   * 
   * @return type
   */
  public function showDashboard()
  {
    $bookings = $this->booking->recent();
    $cottages = $this->cottage->all();
    
    return View::make('admin.dashboard', array( 
        'bookings' => $bookings,       
        'cottages' => $cottages, 
    ));
  }
}

