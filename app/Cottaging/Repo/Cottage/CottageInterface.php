<?php

namespace Cottaging\Repo\Cottage;

/**
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
interface CottageInterface {
  
  /**
   * Create a cottage resource
   * @param array $data validated form input
   */
  public function create(array $data);
  
  /**
   * Update a cottage resource
   * @param array $data validated form input
   */
  public function update($id, array $data);

  /**
   * Return a cottage by it's ID value
   * @param type $id
   */
  public function byId($id);
  
  /**
   * All cottages
   */
  public function all();

  /**
   * Get paginated Cottages
   * 
   * @param int $page page number
   * @param int $limit number per page
   * @return object object with $items and $toalitems for pagination
   */
  public function byPage($page = 1, $limit = 10);

  /**
   * Return a single cottage
   * @param string $slug
   * @return object
   */
  public function bySlug($slug);

  /**
   * Return all cottages within a specific area
   * @param type $area
   */
  public function byArea($area, $page = 1, $limit = 10);
  
  /**
   * Search availability accross all cottages
   * @param array $input
   */
  public function searchAll($input);
  
}

