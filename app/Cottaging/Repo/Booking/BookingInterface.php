<?php

namespace Cottaging\Repo\Booking;

/**
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
interface BookingInterface {
    
    /**
     * Get a single booking info
     * @param type $id
     */
    public function byId($id);
    
    /**
     * An object of bookings for a single cottage
     * @param type $id
     */
    public function byCottage($id);
    
    
    public function create(array $data);

    
    public function update($id, array $data);
    
    public function allFuture();
    
    public function allActive();
    
    public function allPast();
    
    public function recent();
}

