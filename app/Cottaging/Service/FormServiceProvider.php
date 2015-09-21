<?php
namespace Cottaging\Service;

use Cottaging\Service\Form\Cottage\CottageForm;
use Cottaging\Service\Form\Cottage\CottageFormValidator;

use Cottaging\Service\Form\Booking\BookingForm;
use Cottaging\Service\Form\Booking\BookingFormValidator;

use Cottaging\Service\Form\Price\PriceForm;
use Cottaging\Service\Form\Price\PriceFormValidator;

use Illuminate\Support\ServiceProvider;
/**
 * Description of FormServiceProvider
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class FormServiceProvider extends ServiceProvider {
  
  public function register()
  {
    $app = $this->app;
    
    $app->bind('Cottaging\Service\Form\Cottage\CottageForm', function($app)
    {
      return new CottageForm(
              new CottageFormValidator($app['validator']),
              $app->make('Cottaging\Repo\Cottage\CottageInterface')
              );
    });
    
    $app->bind('Cottaging\Service\Form\Booking\BookingForm', function($app)
    {
      return new BookingForm(
                new BookingFormValidator($app['validator']),
                $app->make('Cottaging\Repo\Booking\BookingInterface'),
                $app->make('Cottaging\Repo\Price\PriceInterface')
              );
    });
    
    $app->bind('Cottaging\Service\Form\Price\PriceForm', function($app)
    {
      return new PriceForm(
              new PriceFormValidator($app['validator']),
              $app->make('Cottaging\Repo\Price\PriceInterface')
              );
    });
  }
}

