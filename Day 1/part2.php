<?php

$file = file_get_contents('./input.txt');

$words = [
    'zero', 'one', 'two', 'three', 'four',
    'five', 'six', 'seven', 'eight', 'nine'
];

$wordsString = implode('|', $words);

// Uses positive lookahead to match all numbers represented as words that overlap
// e.g. 'twone' will match both 'two' and 'one'
$regex = "/(?=($wordsString|[0-9]))/";

echo array_sum(array_map(
    callback: function ($line) use ($words, $regex): int {
        if (empty($line)) {
            return 0;
        }

        // match all numbers in the line that are spelled out
        preg_match_all($regex, $line, $matches);

        $numbers = array_map(
            callback: fn (string $match) => is_numeric($match) ? $match : array_flip($words)[$match],
            array: $matches[1],
        );

        // get the first and last number
        $first = reset($numbers);
        $last = end($numbers);

        // add the two numbers and return the result
        return intval("$first$last");
    },
    array: explode("\n", $file)
));
