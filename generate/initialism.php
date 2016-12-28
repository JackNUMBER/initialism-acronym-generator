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

// Roman/Arabic numerals relation
$roman_arabic_numeral_relation = [
    'II'   => '2',
    'III'  => '3',
    'IV'   => '4',
    'V'    => '5',
    'VI'   => '6',
    'VII'  => '7',
    'VIII' => '8',
    'IX'   => '9',
];

// regex parttern
$roman_arabic_numeral_patterns = implode('|', array_keys($roman_arabic_numeral_relation));

// replace pattern
$roman_numeral = [];
$arabic_numeral = [];

foreach ($roman_arabic_numeral_relation as $roman => $arabic) {
    $roman_numeral[] = '/\b(' . $roman . ')\b/';
    $arabic_numeral[] = $arabic;
}

// cli table render
$mask = "| %1.1s | %-8.8s | %-40.40s | %-5.5s |\n";
$mask = "| %1.1s | %-15.30s | %-40.40s | %-5.5s |\n";
echo "\n";
printf($mask, '', 'abbr', 'name', 'words');
printf($mask, '', '', '', '', '');

// process games names
foreach ($names as $name) {
    $abbr = [];
    $ignore = false;
    $words_count = substr_count($name, ' ') + 1; // str_word_count() ignore numbers

    if ($words_count < 2) {
        $ignore = true;
    }

    // there is Roman numerals
    if (preg_match_all('/\b(' . $roman_arabic_numeral_patterns . ')\b/', $name, $m)) {
        $temp = preg_replace($roman_numeral, $arabic_numeral, $name);

        if (preg_match_all('/\b([a-zA-Z]|\d+|:)/', strtoupper($temp), $m)) {
            $abbr[] = str_replace(':', ' ', implode('', $m[1]));
        }
    }

    if (preg_match_all('/\b(' . $roman_arabic_numeral_patterns . '|[a-zA-Z]|\d+|:)/', strtoupper($name), $m)) {
        $abbr[] = str_replace(':', ' ', implode('', $m[1]));
    }

    // cli ignore render
    if ($ignore) {
        $ignore_display = '';
    } else {
        $ignore_display = 'x';
    }

    printf($mask, $ignore_display, '(' . count($abbr) . ') ' . implode(', ', $abbr), $name, $words_count);
}

echo "\n";
?>
