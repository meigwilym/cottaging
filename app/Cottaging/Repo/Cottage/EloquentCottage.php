<?php

namespace Cottaging\Repo\Cottage;

use Cottaging\Repo\Booking\BookingInterface;
use Cottaging\Repo\Area\AreaInterface;
use Cottaging\Repo\Feature\FeatureInterface;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of EloquentCottage
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class EloquentCottage implements CottageInterface{
    
    protected $cottage;
    
    protected $booking;
    
    protected $area;
    
    protected $feature;

    public function __construct(
            Model $cottage, 
            BookingInterface $booking, 
            AreaInterface $area,
            FeatureInterface $feature)
    {
        $this->cottage = $cottage;
        $this->booking = $booking;
        $this->area = $area;
        $this->feature = $feature;
    }
    
    /**
     * 
     * @return type
     */
    public function all()
    {
      return $this->cottage->all();
    }
    
    /**
     * 
     * @param array $data
     */
    public function create(array $data)
    {
      
      $cottage = new \Cottage();
      
      $cottage->name = $data['name'];
      $cottage->slug = \Str::slug($data['name']);
      $cottage->summary = $data['summary'];
      $cottage->description = $data['description'];
      $cottage->accommodation = $data['accommodation'];
      $cottage->start_days = $data['start_days'];
      $cottage->min_duration = $data['min_duration'];
      $cottage->sleeps = $data['sleeps'];
      $cottage->bedrooms = $data['bedrooms'];
      $cottage->bathrooms = $data['bathrooms'];
      $cottage->lat = $data['lat'];
      $cottage->lon = $data['lon'];
      $cottage->page_title = $data['page_title'];
      $cottage->keywords = $data['keywords'];
      $cottage->save();
      
      $cottage->features()->sync($data['feature']);
      
      return $cottage;
    }
    
    /**
     * Update a cottage
     * 
     * @param int $id
     * @param array $data
     * @return boolean
     */
    public function update($id, array $data)
    {
      $cottage = $this->cottage->findOrFail($id);
      
      if(!$cottage) return false;
      
      $cottage->name = $data['name'];
      $cottage->summary = $data['summary'];
      $cottage->description = $data['description'];
      $cottage->accommodation = $data['accommodation'];
      $cottage->start_days = $data['start_days'];
      $cottage->min_duration = $data['min_duration'];
      $cottage->sleeps = $data['sleeps'];
      $cottage->bedrooms = $data['bedrooms'];
      $cottage->bathrooms = $data['bathrooms'];
      $cottage->lat = $data['lat'];
      $cottage->lon = $data['lon'];
      $cottage->page_title = $data['page_title'];
      $cottage->keywords = $data['keywords'];
      $cottage->save();
      
      // @todo update Area and Image
      // $cottage->images()->sync($data['images'])
      
      // features
      $cottage->features()->sync($data['feature']);
      
      return true;
    }

    /**
     * Get a cottage by it's ID
     * 
     * @param integer $id
     * @return object
     */
    public function byId($id)
    {
      return $this->cottage //->with('images', 'areas', 'features')
                           ->find($id);
    }
    
    /**
     * Get all cottages
     * 
     * @param type $page
     * @param type $limit
     * @return type
     */
    public function byPage($page = 1, $limit = 10)
    {
        $cottages = $this->cottage
                        ->with('images', 'areas', 'features')
                        ->skip($limit*($page - 1))
                        ->take($limit)
                        ->get();
        
        $data = new \stdClass;
        $data->cottages = $cottages;
        $data->totalItems = $this->totalCottages();
        
        return $data;
    }
    
    /**
     * Single cottage and its bookings
     * 
     * @param type $slug
     * @return obj, with cottage and bookings
     */
    public function bySlug($slug)
    {
        $cottage = $this->cottage
                        ->with('images', 'areas', 'features')
                        ->where('slug', $slug)
                        ->first();
        
        $bookings = $this->booking
                         ->byCottage($cottage->id, 'first day of this month');
        
        $data = new \stdClass;
        $data->cottage = $cottage;
        $data->bookings = $bookings;
        
        return $data;
    }
    
    /**
     * Total number of cottages
     * @return type
     */
    public function totalCottages()
    {
      return $this->cottage->count();
    }
    
    /**
     * Cottages by Area
     * @param type $area
     * @param type $page
     * @param type $limit
     */
    public function byArea($area, $page = 1, $limit = 10)
    {
      ;
    }
    
    /**
     * Availability across all cottages
     * 
     * @param array $input
     */
    public function searchAll($input)
    {
      
    }
    
}
