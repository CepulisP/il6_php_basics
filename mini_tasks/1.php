<?php

// Parašyti algoritmą, kuris išvestu du vidurkius.
// Vienas skaičių kurie yra mažesni už visų skaičių vidurkį, kitas kurie didesni.
// Jei skaičius lygus vidurkiui, jis turi prisideti, prie didesnių.
//
//[1, 3, 4, 6, 9 ,2, 3, 4, 5, 5, 7, 8, 9, 10, 1, 4, 5,34, 23, 1, 4, 6, 77, 3, 9]
//
//Kurių skaičių daugiau?

function algoOne($array){

    if (count($array)) {                                        // checks if array isn't empty
        foreach ($array as $value) {
            if ($value < array_sum($array) / count($array)) {   // checks if value is above or below total average
                $smallNumbersArray[] = $value;
            } else {
                $bigNumbersArray[] = $value;
            }
        }
        if (count($smallNumbersArray) > count($bigNumbersArray)) {
            $result = 'There are more numbers below average';
        } elseif (count($smallNumbersArray) < count($bigNumbersArray)) {
            $result = 'There are more numbers above average';
        } else {
            $result = 'There is an even amount of numbers above and below average';
        }

        return $result . '<br>Small numbers average: ' . array_sum($smallNumbersArray) / count($smallNumbersArray) .
            '<br>Large numbers average: ' . array_sum($bigNumbersArray) / count($bigNumbersArray);
    }
    return 'Array empty';
}

$arrayOne = [1, 3, 4, 6, 9, 2, 3, 4, 5, 5, 7, 8, 9, 10, 1, 4, 5, 34, 23, 1, 4, 6, 77, 3, 9];
echo algoOne($arrayOne) . '<br>';


//[1000, 2303, 444, 5554, 9993, 45454, 4343, 65656, 65659, 43434, 92, 23456, 758595, 344433]
//
//Rasti didžiausią lyginį skaičių, sumažinti jį 40% ir atspauzdinti toki pat array, su pakeistu skaičiumi.

function algoTwo($array)
{
    $largestEvenNumber = 0;

    foreach ($array as $key => $value) {
        if ($value % 2 == 0 && $value > $largestEvenNumber) {   // checks if value is even and bigger than current largest even number
            $largestEvenNumber = $value;                        // saves new largest even number
            $largestValuePosition = $key;                       // saves it's position
        }
    }

    if (isset($largestValuePosition)) {
        $array[$largestValuePosition] = $largestEvenNumber * 0.6;      // lowers the largest value by 40%
        return $array;
    } else {
        return 'no even values found';
    }
}

$arrayTwo = [1000, 2303, 444, 5554, 9993, 45454, 4343, 65656, 65659, 43434, 92, 23456, 758595, 344433];
echo '<pre>';
print_r(algoTwo($arrayTwo));