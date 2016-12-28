<?php
$max = 20;
$count = 0;

// read file
$file = fopen('XBOX-games_wiki.txt', "r");
$names = [];
while (($line = fgets($file)) !== false) {
    if (isset($max)) {if ($count >= $max) {break;}}
    $names[] = trim($line);
    $count++;
}
fclose($file);

// preset roman numbers
$roman_numeral = [
    'I'    => 1,
    'II'   => 2,
    'III'  => 3,
    'IV'   => 4,
    'V'    => 5,
    'VI'   => 6,
    'VII'  => 7,
    'VIII' => 8,
    'IX'   => 9,
];
/*
// sample
$names = [
    'SCAR : Squadra Corse Alfa Romeo',
    'All-Star Baseball 2003',
    '007: Nightfire',
    'Grand Theft Auto V',
    'Saints Row IV: Re-Elected',
    'Airforce Delta II',
    '4x4 EVO 2',
    'Black',
    'Tenku 2',
];
*/
echo "\n";

// cli table render
$mask = "| %1.1s | %-8.8s | %-40.40s | %-5.5s |\n";
printf($mask, '', 'abbr', 'name', 'words');
printf($mask, '', '', '', '', '');

// process games names
foreach ($names as $name) {
    $ignore = false;
    $words_count = substr_count($name, ' ') + 1; // str_word_count() ignore numbers

    if ($words_count < 2) {
        $ignore = true;
    }

    $name_clean;

    // take first letter of each word, keep complete numbers, keep ":"
    if (preg_match_all('/\b([a-zA-Z]|\d+|:)/', strtoupper($name), $m)) {
        $abbr = str_replace(':', ' ', implode('', $m[1]));
    }

    // cli ignore render
    if ($ignore) {
        $ignore_display = '';
    } else {
        $ignore_display = 'x';
    }

    printf($mask, $ignore_display, $abbr, $name, $words_count);
}

echo "\n";
?>
