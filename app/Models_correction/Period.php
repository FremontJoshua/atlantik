<?php

namespace Models;

class Period extends \Kernel\Object{
    protected static $_table='period';
    
    public static function getPeriod($date) {
        return Period::whereFirst('? between startDate and endDate',[$date]);
    }
}