<?php

namespace Cottaging\Service\Validation;

/**
 * ValidableInterface
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
interface ValidableInterface {
  
  /**
   * Add the data to be validated
   * @param array $input 
   */
  public function with(array $input);
  
  /**
   * Test if the validation passes
   */
  public function passes();
  
  /**
   * Return validation errors
   */
  public function errors();
  
  /** 
   * Add a rule to the rule array
   */
  public function addRule(array $rule);
  
}

