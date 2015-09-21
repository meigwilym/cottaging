<?php

namespace Admin;

use View;

use Cottaging\Repo\Cottage\CottageInterface;
use Cottaging\Repo\Booking\BookingInterface;

class BookingController extends \BaseController {

  protected $booking;  
  protected $cottage;

  public function __construct(
          BookingInterface $booking,
          CottageInterface $cottage
          )
  {
    $this->booking = $booking;
    $this->cottage = $cottage;
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index($period = 'future')
  {
    if($period == 'active')
      $booking = $this->booking->allActive();
    elseif($period == 'past')
      $booking = $this->booking->allPast();
    else
      $booking = $this->booking->allFuture();
    
    return View::make('admin.bookings.index')
            ->withTitle(ucfirst($period))
            ->withBookings($booking);
  }
  
  /*
   * 
   */
  public function cottage($id)
  {
    $cottage = $this->cottage->byId($id);
    $bookings = $this->booking->byCottage($id);
    
    return View::make('admin.bookings.cottage')
            ->withCottage($cottage)
            ->withBookings($bookings);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    echo 'admin.booking.create';
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    
  }

  /**
   * Display the specified booking resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    $booking = $this->booking->byId($id);
    
    return View::make('admin.bookings.single')
            ->withBooking($booking);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    echo 'admin.booking.edit';
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    
  }

}