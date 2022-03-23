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

    public static function arrayToCsv(array $data, string $fileName, bool $addHeaders = true): void
    {
        $file = fopen($fileName, 'a');
        if ($addHeaders) {
            $headers = array_keys($data[0]);
            fputcsv($file, $headers);
        }
        foreach ($data as $element){
            fputcsv($file, $element);
        }
        fclose($file);
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