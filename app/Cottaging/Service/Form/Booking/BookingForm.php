<?php
namespace Cottaging\Service\Form\Booking;

use Cottaging\Service\Validation\ValidableInterface;

use Cottaging\Repo\Booking\BookingInterface;
use Cottaging\Repo\Price\PriceInterface;

use Sentry, Carbon;
/**
 * Booking form
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class BookingForm {
  
  // form data
  protected $data;
  
  // validator
  protected $validator;
  
  // session repo
  protected $booking;
  
  protected $price;
  
  /**
   * 
   * @param \Cottaging\Service\Validation\ValidableInterface $validator
   * @param  $user
   */
  public function __construct(ValidableInterface $validator, BookingInterface $booking, PriceInterface $price)
  {
    $this->validator = $validator;
    $this->booking = $booking;
    $this->price = $price;
  }
  
  /**
   * Create a new booking, set as draft
   * 
   * @param array $input
   */
  public function saveDraft(array $input)
  {
    if(!$this->valid($input))
    {
      return false;
    }
    
    // check if user exists, create get id
    if(Sentry::check()) 
      $user = Sentry::getUser();
    else
    {
      try
      {
          $user = Sentry::findUserByCredentials(array(
              'email'      => $input['email'],
          ));
      }
      catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
      {
        // create a new user
        
        // put single spaces between names, explode in array and pop surname
        $name = preg_replace('/\s+/', ' ', $input['name']);
        $name = explode(' ', $name);
        $last_name = array_pop($name);
        
        $user = Sentry::createUser(array(
                'email' => $input['email'],
                'first_name' => implode(' ', $name),
                'last_name' => $last_name,
                'password' => substr(md5(rand()), 0, 10),
                'activated' => true,
                'telephone' => $input['telephone'],
                'address1' => $input['address1'],
                'address2' => $input['address2'],
                'town' => $input['town'],
                'postcode' => $input['postcode'],
        ));
      }        
    }

    $last_night = Carbon::parse($input['depart'])->subDay()->toDateString();
    $nights = Carbon::parse($input['first_night'])->diffInDays(Carbon::parse($input['depart']));
    $amount = $this->price->calculateByNight($input['cottage_id'], $input['first_night'], $last_night);

    $data['cottage_id'] = $input['cottage_id'];
    $data['client_id'] = $user->id;
    $data['first_night'] = $input['first_night'];
    $data['last_night'] = $last_night;
    $data['nights'] = $nights;
    $data['amount'] = $amount[0]->cost;
    $data['status'] = 'DRAFT';
    
    return $this->booking->create($data);
  }
  
  /**
   * Update a new booking
   * 
   * @param array $input
   */
  public function update($id, array $input)
  {
    if(!$this->valid($input))
    {
      return false;
    }
    
    return $this->booking->update($id, $input);
  }
  
  /**
   * Return validation errors
   */
  public function errors()
  {
    return $this->validator->errors();
  }
  
  /**
   * validation check
   * 
   * @param array $input
   */
  public function valid(array $input)
  {
    return $this->validator
            ->with($input)
            ->passes();
  }
}
