<?php

namespace app\widgets;


use app\assets\libs\HighlightJsAsset;
use app\components\helpers\JsonHelper;
use yii\base\Widget;

class HighlightJs extends Widget
{
    public const LANGUAGE_HTML = 'html';
    public const LANGUAGE_PHP = 'php';
    public const LANGUAGE_JS = 'javascript';
    public const LANGUAGE_SQL = 'sql';
    public const LANGUAGE_JSON = 'json';

    public $src;

    public $language;

    public function init()
    {
        HighlightJsAsset::register($this->view);
    }

    public function run()
    {
        if(!$this->src) {
            return '';
        }
        $this->src = trim($this->src);
        if ($this->language == self::LANGUAGE_JSON) {
            $this->src = JsonHelper::decode($this->src);
            $this->src = JsonHelper::encode($this->src, [JSON_PRETTY_PRINT]);
            $this->src = urldecode($this->src);
        }
        return '<pre><code class="' . $this->language . '">' . htmlspecialchars($this->src) . '</code></pre>';
    }

}