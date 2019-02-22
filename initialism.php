<?php

/* --- Settings --- */

$file_name = 'sample';
// $max = 20;

/* ---------------- */

// read file
$file = fopen($file_name . '.txt', 'r');
$names = [];
$count = 0;
while (($line = fgets($file)) !== false) {
    if (isset($max) && $count >= $max) { break; }
    $names[] = trim($line);
    $count++;
}
fclose($file);

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

// regex pattern
$roman_arabic_numeral_patterns = implode('|', array_keys($roman_arabic_numeral_relation));

// replace pattern
$roman_numeral = [];
$arabic_numeral = [];

foreach ($roman_arabic_numeral_relation as $roman => $arabic) {
    $roman_numeral[] = '/\b(' . $roman . ')\b/';
    $arabic_numeral[] = $arabic;
}

// cli table render
$mask = "| %1.1s | %-15.30s | %-40.40s | %-5.5s |\n";
echo "\n";
printf($mask, '', 'abbr', 'name', 'words');
printf($mask, '', '', '', '', '');

// process games names
$output = [];
foreach ($names as $name) {
    $abbr = [];
    $ignore = false;
    $words_count = substr_count($name, ' ') + 1; // str_word_count() ignore numbers

    if ($words_count < 2) {
        $ignore = true;
    }

    $name_clean = str_replace("'", "", $name);
    $name_clean = html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($name_clean, ENT_QUOTES, 'UTF-8')));

    // there is Roman numerals
    if (preg_match_all('/\b(' . $roman_arabic_numeral_patterns . ')\b/', $name_clean, $m)) {
        $temp = preg_replace($roman_numeral, $arabic_numeral, $name_clean);

        if (preg_match_all('/\b([a-zA-Z]|\d+|:)/', strtoupper($temp), $m)) {
            $abbr[] = str_replace(':', ' ', implode('', $m[1]));
        }
    }

    if (preg_match_all('/\b(' . $roman_arabic_numeral_patterns . '|[a-zA-Z]|\d+|:)/', strtoupper($name_clean), $m)) {
        $abbr[] = str_replace(':', ' ', implode('', $m[1]));
    }

    // cli ignore render
    if ($ignore) {
        $status = 'x';
    } else {
        $status = 'o';
    }

    printf($mask, $status, '(' . count($abbr) . ') ' . implode(', ', $abbr), $name, $words_count);

    if (!$ignore) {
        $temp = $abbr;
        array_unshift($temp, $name);
        $output[] = [
            'type' => 'synonym',
            'synonyms' => $temp,
        ];
    }
}

file_put_contents($file_name . '.json', json_encode($output, JSON_PRETTY_PRINT));

echo "\n";
?>
