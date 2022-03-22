<?php

namespace Helper;

class Csv
{
    public static function csvToArray(string $fileName, bool $assignHeaders = true): array
    {
        $data = [];
        $file = fopen($fileName, 'r');
        while(!feof($file)){
            $line = fgetcsv($file);
            if (!empty($line)){
                $data[] = $line;
            }
        }
        fclose($file);

        return $assignHeaders ? self::assignHeaders($data) : $data;
    }

    public static function assignHeaders(array $array): array
    {
        $headers = $array[0];
        unset($array[0]);
        $data = [];
        foreach ($array as $key => $element){
            foreach ($element as $valueKey => $value){
                $data[$key][$headers[$valueKey]] = $value;
            }
        }
        return $data;
    }
}