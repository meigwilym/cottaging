<?php

use Cottaging\Service\Form\Booking\BookingForm;
use Cottaging\Repo\Price\PriceInterface;
use Cottaging\Repo\Booking\BookingInterface;

/**
 * Description of BookingController
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class BookingController extends BaseController{
  
  protected $bookingform;
  
  protected $price;
  
  protected $booking;

  /**
   * 
   */
  public function __construct(BookingForm $form, PriceInterface $price, BookingInterface $booking)
  {
    $this->bookingform = $form;
    $this->price = $price;
    $this->booking = $booking;
  }
  
  /**
   * Booking form, used when there's an error and need to show the form again
   * 
   * @param type $param
   */
  public function bookingForm($param)
  {
    // need bkng = first_night, depart, nights, name
    return View::make('booking.cottage')
            ->with('bkng', $bkng)
            ->nest('form', 'booking.form', Input::all());
  }
  
  /**
   * :POST
   * Save a booking
   * 
   * - check for user
   * - validate form
   * - calculate price
   * - save
   */
  public function storeBooking($cottage_name)
  {
    $booking = $this->bookingform->saveDraft(Input::all());
    
    if($booking === false)
    {
      return \Redirect::to('booking/'.$cottage_name)
              ->withInput()
              ->withErrors( $this->bookingform->errors())
              ->with('status', 'error');
    }
    else
    {
      return \Redirect::action('BookingController@paymentBooking', $booking);
    }
  }
  
  /**
   * Show booking details
   * take payment
   */
  public function paymentBooking($id)
  {
    $booking = $this->booking->byId($id);
    
    return View::make('booking.payment')
            ->withBooking($booking);
  }
  
  /**
   * :POST
   */
  public function processPayment($id)
  {
    $booking = $this->booking->byId($id);
   
    // Set the API key
    Stripe::setApiKey(Config::get('laravel-stripe::stripe.api_key'));

    // Get the credit card details submitted by the form
    $token = Input::get('stripeToken');

    // Charge the card
    try
    {
      $charge = Stripe_Charge::create(array(
                  "amount" => $booking->amount,
                  "currency" => "gbp",
                  "card" => $token,
                  "description" => 'Holiday Booking with '.\Config::get('cottaging.site-name'))
      );

      // If we get this far, we've charged the user successfully
      $booking->status = 'COMPLETE';
      $booking->paid = $booking->amount;
      $booking->save();
      
      Event::fire('booking.confirm', array($booking));

      return Redirect::action('BookingController@confirmBooking', $id);
    } 
    catch (Stripe_CardError $e)
    {
      // Payment failed
      return Redirect::action('BookingController@paymentBooking' . $id)
              ->with('message', 'Your payment has failed.');
    }
  }
  
  /**
   * Confirm the booking
   * 
   * @param type $id
   * @return type
   */
  public function confirmBooking($id)
  {
    $booking = $this->booking->byId($id);
    
    return View::make('booking.confirm')
            ->withBooking($booking);
  }
  
}
