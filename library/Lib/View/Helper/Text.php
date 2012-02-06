<?php

/**
 * Description of Truncate
 *
 * @author davi
 */
class Lib_View_Helper_Text
{

    public function truncate($string, $length = 140)
    {
        if(strlen($string) > $length){
            return htmlspecialchars(substr($string, 0, $length)) . '...';
        }
        
        return $string;
    }

}
