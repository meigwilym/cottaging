<?php

namespace Cottaging\Repo\Area;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of EloquentArea
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class EloquentArea implements AreaInterface {
    
    protected $area;

    public function __construct(Model $area)
    {
        $this->area = $area;
    }
    
    /**
     * All areas
     * @return type
     */
    public function all()
    {
      return $this->area->groupBy('parent_id')->get();
    }
    
    /**
     * All areas, sorted hierarchically
     */
    public function allSorted()
    {
      $areas = $this->all();
      $hierarchy = array();
      
      // parent/child sorting...
      
      return $hierarchy;
    }
    
    /**
     * All cottages in an area
     * @param type $area_slug
     * @param type $page
     * @param type $items
     */
    public function byAreaSlug($area_slug, $page = 1, $items = 10)
    {
        $cottage = $this->area
                        ->with('cottages')
                        ->where('slug', $area_slug)
                        ->skip($items * ($page - 1))
                        ->take($items)
                        ->get();
    }
    
    
    
}

