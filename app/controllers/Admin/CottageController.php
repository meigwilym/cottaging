<?php

namespace Admin;

use View;

use Cottaging\Repo\Cottage\CottageInterface;
use Cottaging\Service\Form\Cottage\CottageForm;
use Cottaging\Repo\Feature\FeatureInterface;
use Cottaging\Repo\Area\AreaInterface;
use Cottaging\Repo\Image\ImageInterface;
use Cottaging\Repo\Price\PriceInterface;
use Cottaging\Service\Form\Price\PriceForm;

use Response, Request, Input, Redirect;

class CottageController extends \BaseController {

  protected $cottage;  
  protected $cottageform;
  protected $feature;
  protected $image;
  protected $price; 
  protected $priceform;
  
  public function __construct(
          CottageInterface $cottage, 
          CottageForm $cottageform,
          AreaInterface $area,
          FeatureInterface $feature,
          ImageInterface $image,
          PriceInterface $price,
          PriceForm $priceform)
  {
    $this->cottage = $cottage;
    $this->cottageform = $cottageform;
    $this->area = $area;
    $this->feature = $feature;
    $this->image = $image;
    $this->price = $price;
    $this->priceform = $priceform;
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $cottages = $this->cottage->all();
    
    return View::make('admin.cottage.index')
            ->withCottages($cottages);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    $features = $this->feature->all();
    $areas = $this->area->all();
    
    return View::make('admin.cottage.create', compact('areas', 'features'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    $cottage = $this->cottageform->save(\Input::all());
    
    if($cottage)
    {
      return Redirect::route('admin.cottage.edit', $cottage->id)
              ->with('status', 'success');
    }
    else
    {
      return Redirect::back()
              ->withInput()
              ->withErrors( $this->cottageform->errors())
              ->with('status', 'error');
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    $cottage = $this->cottage->byId($id);
    
    return View::make('admin.cottage.show', compact('cottage'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $cottage = $this->cottage->byId($id);
    $features = $this->feature->all();
    $areas = $this->area->all();
    
    return View::make('admin.cottage.edit', compact('cottage', 'areas', 'features'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    if($this->cottageform->update($id, \Input::all()))
    {
      return Redirect::to('admin/cottage')
              ->with('status', 'success');
    }
    else
    {
      return Redirect::to('admin/cottage/'.$id.'/edit')
              ->withInput()
              ->withErrors( $this->cottageform->errors())
              ->with('status', 'error');
    }
  }
  
  /**
   * :POST
   * 
   * @param int $id
   */
  public function updateImages($id)
  {
    $input = \Input::all();
    $rules = array(
        'file' => 'image|max:5000|mimes:jpeg,jpg',
    );
 
    $validation = \Validator::make($input, $rules);
 
    if ($validation->fails()) return \Response::make($validation->messages->first(), 400);
    
    $upload_success = $this->imageprocessor(\Input::file('file'));
    
    if($upload_success)
      return \Response::json(array('status' => 'success', 'fullpath' => $filename), 200);
    else
      return \Response::json(array('status' => 'error'), 400);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    echo 'destroy';
  }

}