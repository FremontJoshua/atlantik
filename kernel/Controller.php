<?php

namespace Kernel;

abstract class Controller {

    static protected $_view;

    static function setView(View $view) {
        return self::$_view = $view;
    }

    static function getView(){
        return self::$_view ;
    }
    static function redirect($controllerName, $actionName, $params=[]) {
        $paramsUrl='';
        foreach($params as $key=>$value){
            $paramsUrl.='&'.$key.'='.$value;                    
        }
        header('Location:.?controller='.$controllerName.'&action='.$actionName.$paramsUrl);
    }
    static abstract public function _setAction($actionName);
}
