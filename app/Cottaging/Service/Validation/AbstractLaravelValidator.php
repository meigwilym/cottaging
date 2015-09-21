<?php

namespace Cottaging\Service\Validation;

use Illuminate\Validation\Factory as Validator;

/**
 * AbstractLaravelValidator
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
abstract class AbstractLaravelValidator implements ValidableInterface{
  
  /**
   * Validator
   * @var \Illuminate\Validation\Factory 
   */
  protected $validator;
  
  /**
   * Validation data key => value array
   * @var Array
   */
  protected $data = array();
  
  /**
   * Validation errors
   * @var Array
   */
  protected $errors = array();
  
  /**
   * Validatio rules
   * @var Array
   */
  protected $rules = array();
  
  /**
   * Validation custom messages
   * @var Array
   */
  protected $messages = array();
  
  /**
   * Construct and inject Laravel's validator
   * 
   * @param \Illuminate\Validation\Factory $validator
   */
  public function __construct(Validator $validator)
  {
    $this->validator = $validator;
  }
  
  /**
   * Set data to validate
   * 
   * @param array $input
   * @return \Cottaging\Service\Validation\AbstractLaravelValidator
   */
  public function with(array $input)
  {
    $this->data = $input;
    
    return $this;
  }
  
  /**
   * Validation passes or fails
   * 
   * @return Boolean
   */
  public function passes()
  {
    $validator = $this->validator->make($this->data, $this->rules, $this->messages);
    
    if($validator->fails())
    {
      $this->errors = $validator->messages();
      return false;
    }
    
    return true;
  }
  
  /**
   * Return any errors
   * @return array 
   */
  public function errors()
  {
    return $this->errors;
  }
  
  /**
   * Adds a validation rule to the stack
   * 
   * overwrites or appends
   * 
   * @param array $rule
   * @param bool $overwrite
   */
  public function addRule(array $rule, $overwrite = false)
  {
    if($overwrite)
    {
      array_merge($this->rules, $rule);
    }
    else
    {
      $val = '';
      if(array_key_exists(key($rule), $this->rules))
      {
        $val = $this->rules[key($rule)].'|';
      }
      $this->rules[key($rule)] = $val.$rule[key($rule)];
    }
    
    return $this;
  }
  
}
