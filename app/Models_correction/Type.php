<?php

namespace Models;

class Type extends \Kernel\Object{
    protected static $_table='type';
    
    public function getPrice($date,  \Models\Link $link) {
        $period = Period::getPeriod($date);
        return Price::findOne(['period_id'=>$period->id,'type_id'=>$this->id,'link_id'=>$link->id])->price;
    }
}