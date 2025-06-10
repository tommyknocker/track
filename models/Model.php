<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use yii\db\ActiveRecord;

class Model extends ActiveRecord
{
    protected function isSearchModel(): bool
    {
        return str_contains(static::class, 'Search');
    }

    public static function getList(): array
    {
        return ArrayHelper::map(static::find()
            ->select(['id', 'name'])
            ->orderBy(['name' => SORT_ASC])
            ->asArray()
            ->all(), 'id', 'name');
    }
}