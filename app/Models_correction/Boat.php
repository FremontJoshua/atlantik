<?php

namespace Models;

class Boat extends \Kernel\Object {

    protected static $_table = 'boat';

    /**
     * 
     * @param \Models\Category $category
     * @return int
     */
    public function getCapacity(Category $category) {
        $capacity = Capacity::findOne(['category_id'=>$category->id,'boat_id'=>$this->id]);
        if($capacity==null){
            return 0;
        }
        return $capacity->number;
    }
    /**
     * 
     * @return type
     */
    public function getCrossings() {
        return Crossing::find(['boat_id'=>$this->id]);
    }
    
    public function getAverageQuantity(Category $category) {
        $crossings = $this->getCrossings();
        $sum=0;
        foreach ($crossings as $crossing) {
            $sum+=$crossing->getQuantityCategory($category);
        }
        return $sum/$this->getCapacity($category);
    }
}
