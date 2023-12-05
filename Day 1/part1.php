<?php

$file = file_get_contents('./input.txt');

echo array_sum(array_map(
    callback: function ($line): int {
        if (empty($line)) {
            return 0;
        }

        // remove all non-numeric characters
        $numbers = preg_replace('/[^0-9]/', '', $line);


        // get the first and last number
        $first = substr($numbers, 0, 1);
        $last = substr($numbers, -1);

        // add the two numbers and return the result
        return intval("$first$last");
    },
    array: explode("\n", $file)
));
