<?php
namespace Cottaging\Service\Form\Cottage;

use Cottaging\Service\Validation\ValidableInterface;
use Cottaging\Repo\Cottage\CottageInterface;
/**
 * Description of CottageForm
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class CottageForm {
  
  // form data
  protected $data;
  
  // validator
  protected $validator;
  
  // session repo
  protected $cottage;
  
  /**
   * 
   */
  public function __construct(ValidableInterface $validator, CottageInterface $cottage)
  {
    $this->validator = $validator;
    $this->cottage = $cottage;
  }
    
  /**
   * Create a new Cottage
   * 
   * @param array $input
   */
  public function save(array $input)
  {
    if(!$this->valid($input))
    {
      return false;
    }
    
    return $this->cottage->create($input);
  }
  
  /**
   * Update a Cottage
   * 
   * @param int $id
   * @param array $input
   */
  public function update($id, array $input)
  {
    if(!$this->valid($input))
    {
      return false;
    }
    
    return $this->cottage->update($id, $input);
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

