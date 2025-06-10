<?php

namespace app\components\helpers;


use Yii;

class TextHelper
{
    public static function hasText($haystack, $needle): bool
    {
        if (is_array($haystack)) {
            $haystack = array_shift($haystack);
        }

        if (is_array($haystack)) {
            Yii::error($haystack, __METHOD__);
            $haystack = null;
        }

        return mb_strpos($haystack, $needle, 0, 'UTF-8') !== false;
    }

    public static function hasUpperCase(string $value): bool
    {
        return ctype_upper($value);
    }

    public static function getPos(string $haystack, ?string $needle): false|int
    {
        return mb_strpos($haystack, $needle, 0, 'UTF-8');
    }

    public static function subStr($str, $start = 0, $length = null): string
    {
        return mb_substr($str, $start, $length, 'UTF-8');
    }

    public static function getLen($str): false|int
    {
        return mb_strlen($str, 'UTF-8');
    }

    public static function truncate($text, $len = 20): string
    {
        if (self::getLen($text) > ($len-3)) {
            $result = mb_substr($text, 0, $len, 'UTF-8') . '...';
        } else {
            $result = $text;
        }
        return $result;
    }

    public static function stripSymbols($str, $symbols = []): string
    {
        foreach ($symbols as $s) {
            $str = str_replace($s, '', $str);
        }
        return $str;
    }

    public static function toCamelCase(string $value): string
    {
        $chunks = ArrayHelper::safeExplode($value, '_');
        $items = [];
        foreach ($chunks as $key => $item) {
            if ($key) {
                $items[] = ucfirst($item);
            } else {
                $items[] = strtolower($item);
            }
        }
        return implode('', $items);
    }

    /**
     * @param int $length
     * @param string $characters
     * @return string
     * @throws \Exception
     */
    public static function generateRandomString(
        int $length = 10,
        string $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}