<?php
namespace Cottaging\Repo\Feature;

use Illuminate\Database\Eloquent\Model;

/**
 * EloquentFeature
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class EloquentFeature implements FeatureInterface{
  
  protected $feature;
  
  public function __construct(Model $feature)
  {
    $this->feature = $feature;
  }


  public function create(array $data)
  {
    return;
  }
  
  /**
   * Update an existing Feature
   * @param int $id
   * @param array $data
   * @return boolean
   */
  public function update($id, array $data)
  {
    return;
  }
  
  /**
   * Return a single Feature, specified by its ID
   * @param type $id
   * @return object Illuminate\Database\Eloquent\Collection
   */
  public function byId($id)
  {
    return $this->feature->find($id);
  }
  
  /**
   * Return all features
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function all()
  {
    return $this->feature->all();
  }
}

