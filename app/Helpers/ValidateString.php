<?php

namespace App\Helpers;

class ValidateString
{
    public static function removeCharacterSpecial(string $string)
    {
        
         $string = preg_replace('/[^\p{L}\p{N}\s]/u', '', $string); 
       
         $string = str_replace(' ', '', $string);
        return $string;
    }
}
