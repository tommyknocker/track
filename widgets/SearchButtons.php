<?php

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Url;

class SearchButtons extends Widget
{

    /**
     * @var string
     */
    public $resetUrl;

    /**
     * @var bool
     */
    public $exportToCSV;

    /**
     * @var string
     */
    public $exportToCSVRoute;

    /**
     * @var bool
     */
    public $extendedFilter = false;

    /**
     * @var bool
     */
    public $showHr = true;

    /**
     * @var string
     */
    public $clearUrl;


    public function run(): string
    {
        if (!$this->resetUrl) {
            $this->resetUrl = Url::to(['index']);
        }

        return $this->render('searchButtons',
            [
                'resetUrl' => $this->resetUrl,
                'exportToCSV' => $this->exportToCSV,
                'exportToCSVRoute' => $this->exportToCSVRoute,
                'extendedFilter' => $this->extendedFilter,
                'showHr' => $this->showHr,
                'clearUrl' => $this->clearUrl
            ]);
    }

}