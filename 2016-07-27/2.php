<?php
/**
 * A small program 2.php which tokenizes text and counts word frequency.
 *   Outputs "<frequency> <token>\n" for each token found, in descending order.
 *
 * PHP version >= 5.5
 *
 * @author Nalin Singapuri <nalins@gmail.com>
 * @see http://nalin.singapuri.com
 *
 * @example
 *   echo "this is a test, a really bad test" > 2.txt;
 *   php 2.php 2.txt;
 *
 * @todo validate cli filename
 * @todo validate non-empty file
 * @todo implement -h / --help
 */

$file = $argv[1];
$handle = fopen($file, 'r');

$s = fread($handle, filesize($file));
$s = trim(preg_replace('/[^A-z]+/', ' ', $s));

$tokens = explode(' ', $s);
$tokenCounts = [];

foreach ($tokens as $token) {
    if (isset($tokenCounts[$token])) {
        $tokenCounts[$token]++;
    } else {
        $tokenCounts[$token]=1;
    }
}

arsort($tokenCounts);

foreach ($tokenCounts as $token => $count) {
    echo "$count $token" . PHP_EOL;
}

?>