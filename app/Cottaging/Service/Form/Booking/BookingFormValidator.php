<?php

namespace Cottaging\Service\Form\Booking;

use Cottaging\Service\Validation\AbstractLaravelValidator;
/**
 * Description of BookingFormLaravelValidator
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class BookingFormValidator extends AbstractLaravelValidator {
  
  protected $rules = array(
      'name' => 'required|min:2',
      'email' => 'required|min:4|max:32|email',
      'telephone' => 'required',
      'address1' => 'required',
      'address2' => '',
      'town' => 'required',
      'postcode' => 'required',
      
      'first_night' => 'required|after:now',
      'depart' => 'required',
  );
  
  protected $messages = array(
      'first_night.after' => 'The arrival date must be in the future',
      'depart.after' => 'The departure date must be after the arrival date',
  );
  
}

