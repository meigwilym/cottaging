<?php

namespace Cottaging\Service\Calculator;

use \Cottaging\Repo\Price\PriceInterface;

/**
 * PriceCalculator
 * 
 * calculate the price of a booking
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class PriceCalculator {
  
  protected $price;


  /**
   * - PricesInterface repo
   */
  public function __construct(PriceInterface $price)
  {
    $this->price = $price;
  }
  
  /**
   * 
   * @param \Cottaging\Service\Calculator\Cottage $cottage
   * @param type $first_night
   * @param type $last_night
   * @return string
   */
  public function cost($cottage_id, $first_night, $last_night)
  {
    return $this->price->calculateByNight($cottage_id, $first_night, $last_night);
  }
  
}

