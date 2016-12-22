<?php

namespace Models;

class Crossing extends \Kernel\Object {

    protected static $_table = 'crossing';

    /**
     * 
     * @return \Models\Boat
     */
    public function getBoat() {
        return new Boat($this->boat_id);
    }

    /**
     * 
     * @param \Models\Category $category
     * @return int
     */
    public function getCapacity(Category $category) {
        return $this->getBoat()->getCapacity($category);
    }

    /**
     * 
     * @return Booking
     */
    public function getBookings() {
        return Booking::find(['crossing_id' => $this->id]);
    }

    /**
     * 
     * @param \Models\Type $type
     */
    public function getQuantity(Type $type) {
        $bookings = $this->getBookings();
        $quantity = 0;
        foreach ($bookings as $booking) {
            $quantity+=$booking->getQuantity($type);
        }
        return $quantity;
    }
    /**
     * 
     * @param \Models\Category $category
     * @return int
     */
    public function getQuantityCategory(Category $category) {
        $types = $category->getTypes();
        $quantity = 0;
        foreach ($types as $type) {
            $quantity += $this->getQuantity($type);
        }
        return $quantity;
    }
    /**
     * 
     * @param \Models\Category $category
     * @return int
     */
    public function getQuantityFree(Category $category) {
        return $this->getCapacity($category)-$this->getQuantityCategory($category);
    }
    
    public function getLink() {
        return new Link($this->link_id);
    }
    
    private function getTurnoverType(Type $type){        
        $quantity= $this->getQuantity($type);
        $price=$type->getPrice($this->date, $this->getLink());
        return $quantity*$price;
    }
    
    public function getTurnover() {
        $types = Type::getAll();
        $turnover=0;
        foreach ($types as $type) {
            $turnover+=$this->getTurnoverType($type);
        }
        return $turnover;
    }
}