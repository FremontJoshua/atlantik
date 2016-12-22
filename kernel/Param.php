<?php

namespace Kernel;

class Param extends Object{
    protected static $_table='param';
    
    public static function get($key){
        return self::findOne(['key'=>$key])->value;
    }
}