<?php
namespace Admin\Cottage;

use Cottaging\Repo\Price\PriceInterface;
use Cottaging\Service\Form\Price\PriceForm;

use Input, Redirect;

/**
 * Description of PriceController
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class PriceController extends \BaseController{
  
  protected $price;
  
  protected $priceForm;
  
  public function __construct(PriceInterface $price, PriceForm $priceForm)
  {
    $this->price = $price;
    $this->priceForm = $priceForm;
  }
  
  /**
   * :POST
   * 
   * @param type $id
   */
  public function update($cottage_id)
  {
    $this->priceForm->setCottage($cottage_id)
            ->setInput(Input::get('price'))
            ->prepareRules();
    
    if($this->priceForm->save())
    {
      return Redirect::action('Admin\CottageController@edit', array($cottage_id))
              ->withMessage('Saved Prices');
    }
    else
    {
      return Redirect::action('Admin\CottageController@edit', array($cottage_id))
            ->withInput()
            ->withErrors($validation->messages());
    }
  }
  
}
