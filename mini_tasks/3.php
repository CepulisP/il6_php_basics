<?php

$arr = [1, 12, 23, 94, 83, 3, 34, 6, 9, 5, 34, 56, 94, 45, 6, 7, 45, 43, 92, 3];

foreach ($arr as $x) {
    if ($x % 2) {
        $odd[] = $x;
        continue;
    }
    $even[] = $x;
}

echo 'Lyginiu vidurkis: ' . array_sum($even) / count($even) . '<br>';
echo 'Didziausias lyginis: ' . max($even) . '<br>';
echo 'Nelyginiu vidurkis: ' . array_sum($odd) / count($odd) . '<br>';
echo 'Didziausias nelyginis: ' . max($odd) . '<br>';