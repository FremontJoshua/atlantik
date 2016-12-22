<?php

namespace Models;

/**
 * Description of Category
 *
 * @author usersio
 */
class Category extends \Kernel\Object {
    //put your code here
    protected static $_table = 'category';
    
    public function getTypes() {
        return Type::find(['category_id'=>$this->id]);
    }
}
