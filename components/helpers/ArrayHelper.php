<?php

namespace app\components\helpers;

class ArrayHelper extends \yii\helpers\ArrayHelper
{

    public static function dropDownDownListFormat($array, $keyField, $valueField): array
    {
        $result = [];
        foreach ($array as $value) {
            if (is_object($value)) {
                $result[$value->$keyField] = $value->$valueField;
            } else {
                $result[$value[$keyField]] = $value[$valueField];
            }
        }
        return $result;
    }

    public static function addDropDownEmptyValue($array, $title = 'Неважно', $nullIndex = null): array
    {
        $result = [];
        $result[$nullIndex] = $title;
        foreach ($array as $key => $value) {
            $result[$key] = $value;
        }
        return $result;
    }

    public static function getMaxValue($rows, $key): mixed
    {
        $max = null;

        foreach ($rows as $row) {
            $value = (float)$row[$key];
            if (is_null($max)) {
                $max = $value;
            } else {
                $max = max($max, $value);
            }
        }

        return $max;
    }

    public static function getMaxSubValue($rows): mixed
    {
        $max = null;

        foreach ($rows as $row) {
            if (is_null($max)) {
                $max = max($row);
            } else {
                $max = max($max, max($row));
            }
        }

        return $max;
    }

    public static function getItemByField($array, $field, $value): mixed
    {
        $result = null;

        foreach ($array as $item) {
            if ($item[$field] === $value) {
                $result = $item;
                break;
            }
        }

        return $result;
    }

    public static function getSumValue($rows, $key): int
    {
        $result = 0;
        foreach ($rows as $row) {
            $result += $row[$key];
        }
        return $result;
    }

    public static function getMaxValue2($rows, $key1, $key2): mixed
    {
        $max = null;

        foreach ($rows as $row) {
            $value = (float)$row[$key1][$key2];
            if (is_null($max)) {
                $max = $value;
            } else {
                $max = max($max, $value);
            }
        }

        return $max;
    }

    public static function getDuplicateValue($array, $key): mixed
    {
        $result = self::getValue($array, $key);
        if (is_array($result)) {
            $result = array_shift($result);
        }
        return $result;
    }

    /**
     * @param $str
     * @param string $delimiter
     * @return array
     */
    public static function safeExplode($str, string $delimiter = ','): array
    {
        $result = [];
        $chunks = explode($delimiter, $str);
        foreach ($chunks as $chunk) {
            $chunk = trim($chunk);
            if ($chunk) {
                $result[] = $chunk;
            }
        }
        return $result;
    }

    public static function splitByChunks($array, $chunkSize = 10): array
    {
        $result = [];
        for ($i = 0, $iMax = count($array); $i < $iMax; $i += $chunkSize) {
            $result[] = array_slice($array, $i, $chunkSize);
        }
        return $result;
    }


    public static function unsetKeys($array, $keys): array
    {
        foreach ($keys as $key) {
            if (isset($array[$key])) {
                unset($array[$key]);
            }
        }
        return $array;
    }

    /**
     * @param $array
     * @return null
     */
    public static function getFirstItem($array): mixed
    {
        $result = null;
        if ($array) {
            $key = array_keys($array)[0];
            $result = $array[$key];
        }
        return $result;
    }

    public static function groupAndCountItems($array, bool $calcCount = true): array
    {
        $result = [];

        foreach ($array as $item) {
            $i = count($result) - 1;
            if ($i < 0) {
                $result[] = [
                    $item => 1
                ];
            } else {
                if (isset($result[$i][$item])) {
                    if ($calcCount) {
                        $result[$i][$item]++;
                    }
                } else {
                    $result[] = [
                        $item => 1
                    ];
                }
            }
        }

        return $result;
    }


    public static function array2csv($data, $delimiter = ';', $enclosure = '"', $escape_char = "\\")
    {
        $f = fopen('php://memory', 'rb+');
        foreach ($data as $item) {
            fputcsv($f, $item, $delimiter, $enclosure, $escape_char);
        }
        rewind($f);
        return stream_get_contents($f);
    }


    public static function csv2array($file, $delimiter = ';')
    {
        return array_map('str_getcsv', file($file));
    }


    public static function objectsToArray(array $objects): array
    {
        $result = [];

        foreach ($objects as $object) {
            $result[] = get_object_vars($object);
        }

        return $result;
    }

    public static function dotToArray(array $array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $keys = explode('.', $key);
            $arr = &$result;
            foreach ($keys as $path) {
                if (!isset($arr[$path]) || !is_array($arr[$path])) {
                    $arr[$path] = [];
                }
                $arr = &$arr[$path];
            }
            $arr = $value;
        }

        return $result;
    }

}