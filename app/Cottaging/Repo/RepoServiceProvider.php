<?php 

namespace Cottaging\Repo;

// models
use Cottage, Booking, Area, Price, Feature, Image;

// repos
use Cottaging\Repo\Cottage\EloquentCottage;
use Cottaging\Repo\Booking\EloquentBooking;
use Cottaging\Repo\Area\EloquentArea;
use Cottaging\Repo\Price\EloquentPrice;
use Cottaging\Repo\Feature\EloquentFeature;
use Cottaging\Repo\Image\EloquentImage;

use Cottaging\Service\Cache\LaravelCache;

use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider {

    public function register()
    {
        $app = $this->app;
        
        //* Cottage
        $app->bind('Cottaging\Repo\Cottage\CottageInterface', function($app)
        {
            return new EloquentCottage(
                    new Cottage,
                    $app->make('Cottaging\Repo\Booking\BookingInterface'),
                    $app->make('Cottaging\Repo\Area\AreaInterface'),
                    $app->make('Cottaging\Repo\Feature\FeatureInterface')
                );
        });
        // */
        // Booking
        $app->bind('Cottaging\Repo\Booking\BookingInterface', function($app)
        {
            return new EloquentBooking(new Booking);
        });
        
        // Area
        $app->bind('Cottaging\Repo\Area\AreaInterface', function($app)
        {
            return new EloquentArea(new Area);
        });
        
        // Price
        $app->bind('Cottaging\Repo\Price\PriceInterface', function($app)
        {
            return new EloquentPrice(new Price, $app->make('Cottaging\Repo\Cottage\CottageInterface'));
        });
        
        $app->bind('Cottaging\Repo\Feature\FeatureInterface', function($app)
        {
          return new EloquentFeature(new Feature);
        });
        
        
        $app->bind('Cottaging\Repo\Image\ImageInterface', function($app)
        {
          return new EloquentImage(new Image);
        });
    }
}