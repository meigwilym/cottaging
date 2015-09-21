<?php

use Cottaging\Repo\Cottage\CottageInterface;

/**
 * Description of SearchController
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class SearchController extends BaseController {
  
  protected $cottage;

  public function __construct(CottageInterface $cottage)
  {
    $this->cottage = $cottage;
  }
  
  /**
   * Search availability accross all accom units
   */
  public function doSearch()
  {
    $result = $this->cottage->searchAll(Input::all());
    
    return Redirect::action('SearchController@showSearch')
            ->withResult($result);
  }
  
  /**
   * Display search results
   * 
   */
  public function showSearch()
  {
    $result = Session::get('result');
    return View::make('cottage.search', compact('result'));
  }
  
}
