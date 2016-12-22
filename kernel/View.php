<?php

namespace Kernel;

class View{
    private $_file;
    
    public function __construct($controller,$action){
        //$file =Param::get('viewDir').implode('/',explode('\\',$controller)).'/'.$action.'.php';
        //$this->setFile($file);
    }
    
    public function setFile($file){
        $this->_file = $file;
        return $this;
    }
    
    public function display(){
        //include($this->_file);
    }
}