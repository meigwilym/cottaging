<?php

/*
 * Nice ul breadcrumb of areas
 */
function area_breadcrumb($ar)
{  
  $html = '<ul class="breadcrumb">';
  foreach($ar as $area)
  {
    $html .= '<li>'.$area['area'].'</li>';
    //$html .= '<li><a href="'.URL::route('areas', array($area['slug'])).'">'.$area['area'].'</a></li>';
  }
  $html .= '</ul>';
  
  return $html;
}

function area_leaf($ar)
{
  usort($ar, 'parent_sort');
  
  $area = array_pop($ar);
  
  return $area['area'];
}

function parent_sort($item1, $item2)
{
  if ($item1['parent_id'] == $item2['parent_id']) return 0;
  return ($item1['parent_id'] > $item2['parent_id']) ? 1 : -1;
}