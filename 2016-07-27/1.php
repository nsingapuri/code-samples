<?php
/**
 * An method to reverse an [indexed] array.
 *
 * PHP version >= 5.5
 *
 * @author Nalin Singapuri <nalins@gmail.com>
 * @see http://nalin.singapuri.com
 *
 * @example
 *   $a = [1,2,3,4];
 *   print_r(arrayReverse($a));
 */

/**
 * Reverse an indexed array
 *
 * @param mixed[] $a
 * @return mixed[]
 */
function arrayReverse($a) {
    $reversed = [];

    for ($i=count($a)-1; $i >= 0; $i--) {
        $reversed[] = $a[$i];
    }

    return $reversed;
}


?>