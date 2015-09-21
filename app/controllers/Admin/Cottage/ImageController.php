<?php
namespace Admin\Cottage;

use Cottaging\Repo\Image\ImageInterface;
use Cottaging\Service\Image\ImageProcessor;

/**
 * Description of ImageController
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class ImageController extends \BaseController {
  
  protected $image;
  
  protected $imageProcessor;
  
  public function __construct(ImageInterface $image, ImageProcessor $imageProcessor)
  {
    $this->image = $image;
    $this->imageProcessor = $imageProcessor;
  }
  
  /**
   * :POST
   * 
   * @param int $id
   */
  public function store($cottage_id)
  {
    $input = \Input::all();
    $rules = array(
        'file' => 'image|max:5000|mimes:jpeg,jpg',
    );
 
    $validation = \Validator::make($input, $rules);
 
    if ($validation->fails()) return \Response::make($validation->messages->first(), 400);
    
    // make the images
    $filename = $this->imageProcessor->process(\Input::file('file'));
    
    // save record
    $saveimg = array('cottage_id' => $cottage_id, 'fullpath' => $filename, 'order_val' => '1');
    $this->image->create($saveimg);
    
    if($filename != false)
      return \Response::json(array('status' => 'success', 'fullpath' => $filename), 200);
    else
      return \Response::json(array('status' => 'error'), 400);
  }
  
  /**
   * :DELETE ajax
   * Delete an image
   * 
   * @param int $cottage_id
   */
  public function destroy($cottage_id)
  {
    $input = \Input::all();
    $rules = array(
        'id' => 'required|integer',
    );
 
    $validation = \Validator::make($input, $rules);
 
    if ($validation->fails()) 
      return \Response::make($validation->errors->first(), 400);
    
    $this->image->destroy(\Input::get('id'));
    
    if(\Request::ajax()) return \Response::json('deleted', 200);
    
    return \Redirect::action('Admin\CottageController@edit', $cottage_id);
  }
 
}
