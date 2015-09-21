<?php
namespace Cottaging\Service\Form\Cottage;

use Cottaging\Service\Validation\AbstractLaravelValidator;

/**
 * CottageFormValidator
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class CottageFormValidator extends AbstractLaravelValidator{
  
  protected $rules = array(
      'name' => 'required|',
      'summary' => 'required|max:155',
      'description' => 'required|',
      'accommodation' => 'required|',
      'start_days' => 'required',
      'min_duration' => 'required|numeric',
      'sleeps' => 'required|numeric',
      'bedrooms' => 'required|numeric',
      'bathrooms' => 'required|numeric',
      'lat' => 'required|',
      'lon' => 'required|',
      'page_title' => 'required|max:70',
      'keywords' => '',
      'feature' => 'required',
  );
  
  protected $messages = array(
      'start_days.required' => 'The accommodation must have at least one start day',
      'feature.required' => 'The accommodation must have at least one feature',
  );
}

