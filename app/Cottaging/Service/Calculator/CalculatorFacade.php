<?php

namespace Cottaging\Service\Calculator;

use Illuminate\Support\Facades\Facade;

/**
 * CalculatorFacade
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class CalculatorFacade extends Facade {
 
    protected static function getFacadeAccessor()
    {
        return 'pricecalculator';
    }
  
}

