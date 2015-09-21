<?php

use Cottaging\Repo\Cottage\CottageInterface;
use \Cottaging\Repo\Price\PriceInterface;
use Cottaging\Service\Form\Booking\BookingForm;

class CottageController extends BaseController {

  protected $cottage;
  protected $price;

  public function __construct(CottageInterface $cottage, PriceInterface $price)
  {
    $this->cottage = $cottage;
    $this->price = $price;
  }

  /**
   * Show all cottages 
   * 
   * @todo Pagination
   * 
   * @return 
   */
  public function getIndex()
  {
    $cottages = $this->cottage->byPage();

    return View::make('cottage.all', array('cottages' => $cottages));
  }

  /**
   * Show a single cottage
   * 
   * @param string $slug
   * @return type
   */
  public function getCottage($slug)
  {
    $cottage = $this->cottage->bySlug($slug);
    $prices = $this->price->getMinMax($cottage->cottage->cottage_id);
    
    return View::make('cottage.single', array(
                'cottage' => $cottage->cottage,
                'bookings' => $cottage->bookings,
                'prices' => $prices,
               )
            )
            ->nest('form', 'booking.form',array('cottage' => $cottage->cottage));
  }
  
  /**
   * :POST
   * Calculate and return a cost quote
   * 
   * @return type
   */
  public function postCost()
  {
    if(!Request::ajax()) return;
    
    // validate 
    $rules = array('cottage_id' => 'required|integer',
                  'first_night' => 'required|date_format:Y-m-d',
                  'depart'      => 'required|date_format:Y-m-d',
        );

    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) 
      return Response::json(array('status' => 'error', 'messages' => $validator->messages()));
    
    $cost = $this->price->calculateByNight(Input::get('cottage_id'), Input::get('first_night'), Input::get('depart'));
    
    return  Response::json(array('status' => 'success', 'cost' => $cost[0]->cost));
  }

}