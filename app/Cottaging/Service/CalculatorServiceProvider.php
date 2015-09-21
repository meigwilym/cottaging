<?php
namespace Cottaging\Service;

use Price;

use Cottaging\Service\Calculator\PriceCalculator;
use Cottaging\Repo\Price\EloquentPrice;
use Illuminate\Support\ServiceProvider;


/**
 * Description of CalculatorServiceProvider
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class CalculatorServiceProvider extends ServiceProvider{

  public function register()
  {
    $app = $this->app;

    $app->bind('pricecalculator', function($app)
    {
      return new PriceCalculator($app->make('Cottaging\Repo\Price\PriceInterface'));
    });
  }
  
}
