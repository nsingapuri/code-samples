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

$s = file_get_contents($argv[1]);

preg_match_all('/\w+/', $s, $tokens);
$tokenCounts = array_count_values($tokens[0]);
arsort($tokenCounts);

foreach ($tokenCounts as $token => $count) {
    echo "{$count} {$token}" . PHP_EOL;
}

?>