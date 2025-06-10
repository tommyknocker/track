<?php

namespace app\assets\libs;


use yii\web\AssetBundle;
use yii\web\View;

class HighlightJsAsset extends AssetBundle
{
    public $js = [
        '//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.6.0/highlight.min.js',
    ];

    public $css = [
        '//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.6.0/styles/default.min.css',
    ];

    public $jsOptions = [
        'position' => View::POS_END
    ];

    /**
     * @param View $view
     * @return static
     */
    public static function register($view)
    {
        $view->registerJs('hljs.highlightAll();');
        return parent::register($view);
    }
}