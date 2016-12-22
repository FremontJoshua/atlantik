<?php

namespace Kernel;

class Utils {

    public static function post($key = null, $default = null) {
        if (isset($_POST[$key])) {
            return $_POST[$key];
        } else {
            return $default;
        }
    }

    public static function get($key = null, $default = null) {
        if (isset($_GET[$key])) {
            return $_GET[$key];
        } else {
            return $default;
        }
    }

    public static function request($key, $default = null) {
        if (isset($_REQUEST[$key])) {
            return $_REQUEST[$key];
        } else {
            return $default;
        }
    }

    public static function postAll() {
        return $_POST;
    }

    public static function getAll() {
        return $_GET;
    }

    public static function requestAll() {
        return $_REQUEST;
    }
    public static function getHashtags($string){
        preg_match_all('/#([^\s]+)/', $string, $matches);
        return $matches[0];        
    }
    public static function displayHashtags($hashtags) {
        $html = '';
        foreach ($hashtags as $hash) {
            $html.= '<a href="#" class="label label-default">' . $hash . '</a> ';
        }
        return $html;
    }

    public static function getStringWithoutHashtag($string){
        $string = str_replace(self::getHashtags($string), '', $string);
        return trim($string);
    }

}
