<?php

namespace app\components;

use app\components\helpers\TextHelper;
use app\widgets\HighlightJs;

class Formatter extends \yii\i18n\Formatter
{
    public function asTruncated($value, $length = 100): string
    {
        return TextHelper::truncate($value, $length);
    }

    public function asThreeDots($value): string
    {
        return '<span class="three-dots-wrapper"><span class="three-dots">' . $value . '</span></span>';
    }

    public function asThreeDotsTruncated($value, $length = 1000): string
    {
        return $this->asThreeDots($this->asTruncated($value, $length));
    }

    public function asHighlightJs($value, $language = 'json'): string
    {
        return HighlightJs::widget([
            'src' => $value,
            'language' => $language
        ]);
    }
}
