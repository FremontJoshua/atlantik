<?php

namespace Models;

/**
 * Description of Booking
 *
 * @author usersio
 */
class Booking extends \Kernel\Object {
    //put your code here
    protected static $_table = 'booking';
    
    /**
     * Quantity of personn on a reservation by type
     * @param \Models\Type $type
     * @return int
     */
    public function getQuantity(Type $type){
        $quantity = Booking_type::findOne(['booking_id'=>$this->id, 'type_id'=>$type->id]);
        //no record for this category so return 0
        if (null === $quantity){
            return 0;
        }else{
            return $quantity->quantity;
        }
    }
}
