<?php

namespace App\Helpers;

class FormatterValue
{
    public static function formatterMoney($value)
    {
        return number_format($value / 100, 2, ',', '.');
    }

}
