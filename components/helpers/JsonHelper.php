<?php

namespace app\components\helpers;

class JsonHelper
{

    public static function encode(mixed $str, array $flags = []): false|string
    {
        $options = JSON_UNESCAPED_UNICODE;
        foreach ($flags as $flag) {
            $options |= $flag;
        }

        return json_encode($str, $options);
    }


    public static function decode(string $str, array $flags = []): array|false
    {
        $options = JSON_UNESCAPED_UNICODE;
        foreach ($flags as $flag) {
            $options |= $flag;
        }

        return json_decode($str, true, 512, $options);
    }
}