<?php

namespace Models;

class Booking extends \Kernel\Object{
    protected static $_table='booking';
    
    /**
     * 
     * @param \Models\Type $type
     * @return int
     */
    public function getQuantity(Type $type) {
        $bookingType= Booking_Type::findOne(['booking_id'=>$this->id,'type_id'=>$type->id]);
        if(is_null($bookingType)){
            return 0;
        }
        return $bookingType->quantity;
    }
}