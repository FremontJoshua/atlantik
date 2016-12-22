<?php

namespace Models;

class Sector extends \Kernel\Object{
    protected static $_table='sector';
    
    public function getLinks() {
        return Link::find(['sector_id'=>$this->id]);
    }
    
    public function getTurnover($date) {
        $links=$this->getLinks();
        $turnover = 0;
        foreach ($links as $link) {
            $turnover+=$link->turnover($date);
        }
        return $turnover;
    }
}