<?php
/**
 * An method to reverse an [indexed] array.
 * Cannot use any builtin methods
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
    $arrayCount = 0;

    foreach ($a as $element) {
        $arrayCount++;
    }

    for ($i=$arrayCount - 1; $i >= 0; $i--) {
        $reversed[] = $a[$i];
    }

    return $reversed;
}


?>