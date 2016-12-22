<?php

namespace Models;

/**
 * Description of Crossing
 *
 * @author usersio
 */
class Crossing extends \Kernel\Object {
    //put your code here
    protected static $_table = 'crossing';
    
    /**
     * Return the boat of the crossing
     * @return \Models\Boat
     */
    public function getBoat() {
        return new Boat($this->boat_id);
    }
    
    /**
     * Capacity of the boat of the crossing
     * @param \Models\Category $category
     * @return type
     */
    public function getCapacity(Category $category) {
        return $this->getBoat()->getCapacity($category);
    }
    
    /**
     * Return all the bookings of the crossing
     * @return type
     */
    public function getBookings() {
        $booking = Booking::find(['crossing_id'=>$this->id]);
        return $booking;
    }
    
    /**
     * Return the quantity of all the bookings of the crossing
     * @param \Models\Type $type
     * @return type
     */
    public function getQuantity(Type $type){
        $bookings = $this->getBookings();
        $quantity = 0;
        foreach ($bookings as $booking) {
            $quantity += $booking->getQuantity($type);
        }
        return $quantity;
    }
    
    /**
     * 
     * @param \Models\Category $category
     * @return type
     */
    public function getQuantityCategory(Category $category) {
        $types = $category->getTypes();
        $quantity = 0;
        foreach ($types as $type) {
            $quantity = $this->getQuantity($type);
        }
        return $quantity;
    }
    
    /**
     * Seats available by category in a crossing
     * @param \Models\Category $category
     * @return type
     */
    public function getAvailablePlaces(Category $category) {
        $capacity = $this->getCapacity($category);
        $types = $category->getTypes();
        $quantity = 0;
        foreach ($types as $type) {
            $quantity += $this->getQuantity($type);
        }
        $available = $capacity - $quantity;
        return $available;
    }
    
    
}
