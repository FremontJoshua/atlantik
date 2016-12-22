<?php

namespace Models;

class Category extends \Kernel\Object{
    protected static $_table='category';
    
    public function getTypes() {
        return Type::find(['category_id'=>$this->id]);
    }
}