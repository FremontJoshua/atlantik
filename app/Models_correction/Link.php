<?php

namespace Models;

class Link extends \Kernel\Object {

    protected static $_table = 'link';

    public function getCrossings($date = null) {
        if (is_null($date)) {
            return Crossing::find(['link_id' => $this->id]);
        } else {
            return Crossing::find(['link_id' => $this->id, 'date' => $date]);
        }
    }

    /**
     * 
     * @param \Models\Type $type
     * @return type
     */
    public function getAverageQuantity(Type $type) {
        $crossings = $this->getCrossings();
        $quantity = 0;
        foreach ($crossings as $crossing) {
            $quantity+=$crossing->getQuantity($type);
        }
        return $quantity / sizeof($crossings);
    }

    public function getTurnover($date) {
        $crossings = $this->getCrossings($date);
        $turnover = 0;
        foreach ($crossings as $crossing) {
            $turnover+=$crossing->getTurnover();
        }
        return $turnover;
    }

}
