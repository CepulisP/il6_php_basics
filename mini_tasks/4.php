<?php
$arr = [1, 12, 23, 94, 83, 3, 34, 6, 9, 5, 34, 56, 94, 45, 6, 7, 45, 43, 92, 3, 4, 93, 4, 5, 87, 45, 67, 89, 23, 41, 43, 75];
$mid = array_sum($arr) / count($arr);
$result = [];
foreach ($arr as $x) {
    if ($x < $mid && $x > $mid / 2) {
        $result[] = $x;
    }
}
echo '<pre>' . print_r($result, 1) . 'there are ' . count($result) . ' numbers in between averages';