<?php

namespace Controllers;

use Kernel\Session,
    Kernel\Utils,
    Kernel\View;

/**
 * Description of TestModels
 *
 * @author usersio
 */
class TestModels extends \Kernel\Controller {
    //put your code here
    public static function _setAction($actionName) {
        self::testModelBoat();
        self::testModelCrossing();
        self::testModelLink();
        self::testModelBooking();
        self::testBookingCrossing();
        
        self::setView(new View('TestModels', 'dashboard'));
        self::getView()->setFile('json.php');
    }
    
    public static function testModelBoat(){
        $boat = \Models\Boat::findOne(['name'=>'Bangor']);
        $categoryA = new \Models\Category(1);
        $categoryB = new \Models\Category(2);
        $categoryC = new \Models\Category(3);
        var_dump($boat->getCapacity($categoryA));
        //var_dump($boat->getAverageQuantity($categoryB));
        if ($boat->getCapacity($categoryA) != 450){
            throw new \Exception();
        }
        if ($boat->getCapacity($categoryB) != 32){
            throw new \Exception();
        }
        if ($boat->getCapacity($categoryC) != 0){
            throw new \Exception();
        }
        /*if ($boat->getAverageQuantity($categoryA) != 0){
            throw new \Exception();
        }*/
    }
    
    public static function testModelCrossing(){
        $crossing = \Models\Crossing::findOne(['id'=>1]);
        $boat = \Models\Boat::findOne(['name'=>'Bangor']);
        $categoryA = new \Models\Category(1);
        $categoryB = new \Models\Category(2);
        $categoryC = new \Models\Category(3);
        
        if ($crossing->getBoat() != $boat){
            throw new \Exception();
        }
        if ($crossing->getCapacity($categoryA) != 450){
            throw new \Exception();
        }
        if ($crossing->getCapacity($categoryB) != 32){
            throw new \Exception();
        }
        if ($crossing->getCapacity($categoryC) != 0){
            throw new \Exception();
        }
    }
    
    public static function testBookingCrossing(){
        $crossing = \Models\Crossing::findOne(['id'=>1]);
        $booking = \Models\Booking::find(['crossing_id'=>1]);
        $type = new \Models\Type(1);
        $categoryA = new \Models\Category(1);
        if ($crossing->getBookings() != $booking){
            throw new \Exception();
        }
        if ($crossing->getQuantity($type) != 7){
            throw new \Exception();
        }
        if ($crossing->getAvailablePlaces($categoryA) != 439){
            throw new \Exception();
        }
    }
    
    public static function testModelBooking(){
        $booking = \Models\Booking::findOne(['name'=>'Julius']);
        $type = new \Models\Type(1);
        if ($booking->getQuantity($type) != 2){
            throw new \Exception();
        }
    }
    
    public static function testModelLink(){
        $link = \Models\Link::findOne(['id'=>1]);
        $typeA = new \Models\Type(1);
        //var_dump($link->averageNumberPlaces($typeA));
        /*if ($link->averageNumberPlaces($categoryA) != 2){
            throw new \Exception();
        }*/
    }
}
