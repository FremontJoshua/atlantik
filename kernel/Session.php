<?php

namespace Kernel;

class Session{
    static public function store($key,$value){
        $_SESSION[$key]=  serialize($value);
    }
    static public function get($key,$default=null){
        if(isset($_SESSION[$key])){
            return unserialize($_SESSION[$key]);
        }else{
            return $default;
        }
    }
}
