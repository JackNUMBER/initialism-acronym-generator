<?php

echo "\n";

$names = [
    'SCAR : Squadra Corse Alfa Romeo',
    'All-Star Baseball 2003',
    '007: Nightfire',
    'Grand Theft Auto V',
    'Saints Row IV: Re-Elected',
];

$mask = "| %-8.8s | %-40.40s | %-7.7s |\n";
printf($mask, 'abbr', 'name', 'numbers');
printf($mask, '', '', '');

foreach ($names as $name) {
    if (preg_match_all('/\b([a-zA-Z]|\d+|:)/', strtoupper($name), $m)) {
        $abbr = str_replace(':', ' ', implode('', $m[1]));
    }

    $number = '';
    if (preg_match('/[0-9]+/', $name, $m)) {
        $number = implode(', ', $m);
    }

    printf($mask, $abbr, $name, $number);
}

echo "\n";
?>
