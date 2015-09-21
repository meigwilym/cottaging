<?php
namespace Cottaging\Service\Image;

use Cottaging\Exceptions\ImageCreateException;
use Intervention\Image\Image as Intervention;
/**
 * ImageProcessor
 * 
 * Save resized image and thumbs
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class ImageProcessor {
  
  protected $directory = 'media';
  
  protected $extension = 'jpg';
  
  protected $large_dim = '747';
  
  protected $thumb_dim = '200';
  
  /**
   * Make a new unique filename
   *
   * @return string
   */
  public function makeFilename()
  {
    return sha1(time().time().rand()) . ".{$this->extension}";
  }
  
  /**
   * Process the file
   * @param type $file
   */
  public function process($file)
  {
    // save original in /media/original/file.jpg
    $filename = $this->makeFilename();
    \Intervention::make($file->getRealPath())->save($this->directory.'/original/'.$filename);

    $this->crop($filename);
    $this->resize($filename);

    return $filename;
  }
  
  /** 
   * Resize an image
   * 
   * @param type $filepath
   * @return type
   */
  public function resize($filename)
  {
    // save max dimension in /media
    return \Intervention::make($this->directory.'/original/'.$filename)
              ->resize($this->large_dim, null, function ($constraint) {
                          $constraint->aspectRatio();
                      })
              ->save($this->directory.'/'.$filename);
  }
  
  /**
   * Crop a file 
   * 
   * @param type $filepath
   * @return type
   */
  public function crop($filename)
  {
    // save 200x200 in /media/thumb/file.jpg
    $thumb = \Intervention::make($this->directory.'/original/'.$filename);
          
    $cropdim = ($thumb->width() >= $thumb->height()) ? $thumb->height() : $thumb->width(); 
      
    $thumb->crop($cropdim, $cropdim)
            ->resize($this->thumb_dim, $this->thumb_dim)
            ->save($this->directory.'/thumb/'.$filename);
    
    return $thumb;
  }

}
