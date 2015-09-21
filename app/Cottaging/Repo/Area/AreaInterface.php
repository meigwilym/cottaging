<?php

namespace Cottaging\Repo\Area;

/**
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
interface AreaInterface {

  public function all();

  public function allSorted();

  /**
   * Return a group of cottages by Area
   * 
   * @param type $area_slug
   */
  public function byAreaSlug($area_slug, $page = 1, $items = 10);
}
