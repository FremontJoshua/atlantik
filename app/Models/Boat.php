<?php

namespace Models;

/**
 * Description of Boat
 *
 * @author usersio
 */
class Boat extends \Kernel\Object {
    //put your code here
    protected static $_table = 'boat';
    
    /**
     * Boat capacity
     * @param \Models\Category $category
     * @return int
     */
    public function getCapacity(Category $category){
        $capacity = Capacity::findOne(['boat_id'=>$this->id, 'category_id'=>$category->id]);
        //no record for this category so return 0
        if (null === $capacity){
            return 0;
        }else{
            return $capacity->number;
        }
        
    }
    
    /**
     * 
     * @return type
     */
    public function getCrossings() {
        return Crossing::find(['boat_id'=>$this->id]);
    }
    
    /**
     * 
     * @param \Models\Category $category
     * @return type
     */
    public function getAverageQuantity(Category $category) {
        $crossings = $this->getCrossings();
        $sum = 0;
        foreach($crossings as $crossing){
            $sum += $crossing->getQuantityCategory($category);
        }
        return $sum/$this->getCapacity($category);
    }
}
