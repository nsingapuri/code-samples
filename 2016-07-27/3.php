<?php
/**
 * An method 'randomIntegers' to return $n random integers between 1 and $m
 *
 * PHP version >= 5.5
 *
 * @author Nalin Singapuri <nalins@gmail.com>
 * @see http://nalin.singapuri.com
 *
 * @example
 *   print_r(randomIntegers(1, 1));
 *   print_r(randomIntegers(100, 10));
 *
 *   print_r(randomIntegers(1, 2)); //throws 'unsolvable edge case'
 */

/**
 * return $n random integers between 1 and $m
 *   assumes that random number has been seeded outside of this function
 *
 * @param int $m the maximum value for an integer
 * @param int $n the number of integers to return
 *
 * @return int[]
 *
 * @throws Exception 'unsolvable edge case' when the number of integers
 *   requested $n is larger than the maximum integer value $m
 */
function randomIntegers($m, $n) {
    if ($m < $n) {
        throw new Exception('unsolvable edge case');
    }

    $returnValue = [];

    while (count($returnValue) < $n) {
        $returnValue[rand(1, $m)] = true;
    }

    return array_keys($returnValue);
}

?>