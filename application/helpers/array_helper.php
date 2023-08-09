<?php

if(!function_exists('to_array')){
    function to_array($arr){
        if(is_array($arr)){
            return $arr;
        } else if (is_object($arr)) {
            return json_decode(json_encode($arr), true);;
        } else  {
            return json_decode($arr);
        }
    }
}