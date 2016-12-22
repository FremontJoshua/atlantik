<?php

namespace Models;

/**
 * Description of Link
 *
 * @author usersio
 */
class Link extends \Kernel\Object {
    //put your code here
    protected static $_table = 'link';
    
    /**
     * 
     * @param type $date
     * @return type
     */
    public function getCrossings($date = null) {
        if(is_null($date)){
            return Crossing::find(['link_id'=>$this->id]);
        }else{
            return Crossig::find(['link_id'=>$this->id, 'date'=>$date]);
        }
        
    }
    
    /**
     * 
     * @param \Models\Type $type
     * @return type
     */
    public function averageNumberPlaces(Type $type){
        $crossings = $this->getCrossings();
        $quantity = 0;
        foreach ($crossings as $crossing) {
                $quantity += $crossing->getQuantity($type);
        }
        return $quantity/sizeof($crossings);
    }
}
