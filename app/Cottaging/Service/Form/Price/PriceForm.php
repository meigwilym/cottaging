<?php
namespace Cottaging\Service\Form\Price;

use Cottaging\Repo\Price\PriceInterface;
use Cottaging\Service\Validation\ValidableInterface;
/**
 * Description of PriceForm
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class PriceForm {
    
  // raw input
  protected $input;
  
  // form data to be validated
  protected $data;
  
  // validator
  protected $validator;
  
  // repo
  protected $price;
  
  // cottage id
  protected $cottage_id;


  public function __construct(ValidableInterface $validator, PriceInterface $price)
  {
    $this->validator = $validator;
    $this->price = $price;
  }
  
  public function setCottage($id)
  {
    $this->cottage_id = $id;
    return $this;
  }

  public function setInput($prices)
  {    
    $this->input = $prices;
    return $this;
  }
  
  public function prepareRules()
  {
    $rules = array();
    $data = array();
    
    // flatten the multidimensional array
    // for validation
    foreach($this->input as $k => $p)
    {
      if(isset($p['id'])) $this->data[$k.'_id'] = $p['id'];
      $this->data[$k.'.cottage_id'] = $p['cottage_id'];
      $this->data[$k.'.start'] = $p['start'];
      $this->data[$k.'.end'] = $p['end'];
      $this->data[$k.'.night_price'] = $p['night_price'];
      
      $rules[$k.'.cottage_id'] = 'required|integer';
      $rules[$k.'.start'] = 'required|date_format:Y-m-d';
      $rules[$k.'.end'] = 'required|date_format:Y-m-d';
      $rules[$k.'.night_price'] = 'required|integer|min:1';
      
    }
    
    $this->validator->addRule($rules);
  }
  
  /**
   * 
   * @param array $input
   * @return boolean
   */
  public function save()
  {
    if(count($this->data) == 0 || !$this->valid($this->data)) 
      return false;
    
    // delete the current set
    $this->price->destroyAllByCottage($this->cottage_id);
    
    // insert the fresh set
    $return = true;
    foreach($this->input as $i)
      $return = $return && $this->price->create($i);
    
    return $return;
  }
  
  /**
   * 
   * @param array $input
   * @return type
   */
  public function valid(array $input)
  {
    return $this->validator
            ->with($input)
            ->passes();
  }
  
  /**
   * 
   * @param type $param
   * @return type
   */
  public function errors($param)
  {
    return $this->validator->errors();
  }
  
}
