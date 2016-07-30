<?php
/**
 * An method 'randomArraySubset' to return $n random values from an array.
 *   note: the randomIntegers function was stolen from 3.php (which generally
 *   would be included, but was copy-pasted for ease of use). The php builtin
 *   array_rand could be used to implement as a one or two liner, but my
 *   my assumption was that 3 and 4 were intended to build upon one another.
 *
 * PHP version >= 5.5
 *
 * @author Nalin Singapuri <nalins@gmail.com>
 * @see http://nalin.singapuri.com
 *
 * @example
 *   $a = [1,2,3,4,5,6,7,8,9,10];
 *   print_r(randomArraySubset($a, 5));
 *
 *   print_r(randomArraySubset($a, 25)); //throws 'unsolvable edge case'
 */

/**
 * Return $n random integers between 1 and $m
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

/**
 * return $n random array elements
 *   assumes that random number has been seeded outside of this function
 *
 * @param mixed $a[]
 * @param int $n the number of integers to return
 *
 * @return mixed[]
 *
 * @throws Exception 'unsolvable edge case' when the number of integers
 *   requested is larger then the size of $a
 */
function randomArraySubset($a, $n) {
    $indexesToUse = randomIntegers(count($a), $n);

    $returnValues = [];
    foreach ($indexesToUse as $index) {
        $returnValues[] = $a[$index-1];
    }

    return $returnValues;
}

?>