<?php

namespace app\components\helpers;

use Yii;

class AppHelper
{
    public static function getHost(): string
    {
        return 'https://' . Yii::$app->request->hostName;
    }

    public static function isCLI(): bool
    {
        return PHP_SAPI === 'cli';
    }


    public static function getId(): string
    {
        $result = Yii::$app->id;
        if (Yii::$app->module) {
            $result .= '-' . Yii::$app->module->id;
        }
        return $result;
    }

    public static function getClassName($className): string
    {
        $classNamePath = explode('\\', $className);
        return end($classNamePath);
    }

}