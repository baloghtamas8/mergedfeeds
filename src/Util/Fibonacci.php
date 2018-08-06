<?php

namespace App\Util;

/**
 * Fibonacci functions, for working with fibonacci numbers
 * @package App\Util
 */
class Fibonacci
{
    /**
     * Get the first n fibonacci numbers
     * @param int $n number of fibonacci numbers
     * @param int $from get only numbers greater than or equal $from
     * @return array
     */
    public static function getNumbers($n = 10, $from = 0)
    {
        $num1 = 0;
        $num2 = 1;

        $ret = [];
        $counter = 0;
        while ($counter < $n){
            if ($num1 >= $from) {
                $ret[] = $num1;
            }
            $num3 = $num2 + $num1;
            $num1 = $num2;
            $num2 = $num3;
            $counter++;
        }

        return $ret;
    }

}