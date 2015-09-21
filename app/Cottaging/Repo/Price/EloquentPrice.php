<?php
namespace Cottaging\Repo\Price;

use Cottaging\Repo\Cottage\CottageInterface;

use Illuminate\Database\Eloquent\Model;

/**
 * PriceEloquent
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class EloquentPrice implements PriceInterface {
  
  protected $price;
  
  protected $cottage;
  
  public function __construct(Model $price, CottageInterface $cottage)
  {
    $this->price = $price;
    $this->cottage = $cottage;
  }
  
  public function create(array $data)
  {
    return $this->price->create($data);
  }
  
  public function update($id, array $data)
  {
    $price = $this->price->find($id);
    
    $price->start = $data['start'];
    $price->end = $data['end'];
    $price->night_price = $data['night_price'];
    
    return $price->save();
  }
  
  public function byCottage($cottage_id)
  {
    $prices = $this->cottage
                  ->with('prices')
                  ->find($cottage_id);
            
    return $prices;
  }
  
  /**
   * Calculate a price for a cottage between two dates
   * 
   * @param int $cottage_id
   * @param string $start first night: yyyy-mm-dd
   * @param string $end last night: yyyy-mm-dd
   */
  public function calculateByNight($cottage_id, $start, $end)
  {
    // http://stackoverflow.com/questions/16306404/calculate-price-between-given-dates-in-multiple-ranges
    
    return \DB::select(
            \DB::raw("SELECT SUM(DATEDIFF(
                LEAST(end + INTERVAL 1 DAY, :end), 
                GREATEST(start, :start)
              ) 
              * night_price) AS cost FROM prices WHERE cottage_id = :cottage_id AND end >= :start2 AND start <= :end2"), 
              array('end' => $end, 'start' => $start, 'cottage_id'=>$cottage_id, 'start2' => $start,'end2' => $end)
            );
  }
  
  /**
   * If booking is a multiple of 7 days
   * 
   * @param int $cottage_id
   * @param string $start datestring yyyy-mm-dd
   */
  public function calculateByWeek($cottage_id, $start)
  {
     $prices = $this->price->select(
            DB::raw('SUM(DATEDIFF(
                LEAST(end + INTERVAL 7 DAY, :end), 
                GREATEST(start, :start)
              ) 
              * night_price) AS nightly'), 
              array('end' => $end, 'start' => $start)
            )
            ->where('end', '>=', $start)
            ->where('start', '<=', $end);
    
    return $prices;
  }
  
  /**
   * 
   * @param type $cottage_id
   */
  public function getMinMax($cottage_id)
  {
    $price['min'] = $this->price->where('cottage_id', '=', $cottage_id)->min('night_price');
    $price['max'] = $this->price->where('cottage_id', '=', $cottage_id)->max('night_price');
    
    return $price;            
  }
  
  /**
   * Delete all prices associated with a cottage
   * 
   * @param int $cottage_id
   */
  public function destroyAllByCottage($cottage_id)
  {
    return $this->price->where('cottage_id', '=', $cottage_id)->delete();
  }
}

