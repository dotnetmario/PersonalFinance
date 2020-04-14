<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Helper extends Model
{
    /**
     * returns the real string type
     * 
     * @param string string
     * @return string
     */
    public static function getStringType($string)
    {
        return gettype(self::getRealStringType($string));
    }

    /**
     * process to get the real string type
     * 
     * @param string string
     * @return mixed
     */
    public static function getRealStringType($string)
    {
        $string = trim($string);

        if(empty($string))
            return "";
        
        // if number
        if(!preg_match("/[^0-9.]+/", $string)){
            if(preg_match("/[.]+/",$string)){
                return (double)$string;
            }else{
                return (int)$string;
            }
        }

        // if boolean
        if($string == "true") 
            return true;

        if($string=="false")
            return false;

        // if string
        return (string)$string;
    }
}
