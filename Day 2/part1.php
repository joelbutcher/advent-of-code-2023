<?php

$file = file_get_contents('./input.txt');

$limits = [
    'red' => 12,
    'green' => 13,
    'blue' => 14,
];

// regex to match all numbers suffixed with the color (e.g. 12 blue; 5 red, 3 green)
$regex = '/(([0-9]+)\s(' . implode('|', array_keys($limits)) . '))/';

echo array_sum(array_map(
    callback: function (string $line) use ($limits, $regex): int {
        if (empty($line)) {
            return 0;
        }

        // Find the prefix + index for the game
        preg_match('/(Game )([0-9]+)(:\s)/', $line, $matches);
        $gameIndex = $matches[2];

        // remove the game index from the line
        $line = str_replace($matches[0], '', $line);

        // turns are separated by a semicolon ';'
        $turns = explode('; ', $line);

        $max = ['red' => 0, 'green' => 0, 'blue' => 0];

        foreach ($turns as $turn) {
            preg_match_all($regex, $turn, $matches);

            // if no matches, the turn is invalid, skip it.
            if (empty($matches[0])) {
                continue;
            }

            foreach ($matches[0] as $match) {
                [$number, $color] = explode(' ', $match);

                $max[$color] = max($max[$color], intval($number));
            }
        }

        return $max['red'] <= 12 && $max['green'] <= 13 && $max['blue'] <= 14
            ? intval($gameIndex)
            : 0;
    },
    array: explode("\n", $file)
));
