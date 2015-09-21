<?php
namespace Cottaging\Repo\Feature;

/**
 * FeatureInterface
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
interface FeatureInterface {
  
  public function create(array $data);
  
  public function update($id, array $data);
  
  public function byId($id);
  
  public function all();
    
}

