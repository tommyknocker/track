<?php

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Url;

class SearchButtons extends Widget
{

    public $resetUrl;

    public $exportToCSV;

    public $exportToCSVRoute;

    public $extendedFilter = false;

    public $showHr = true;

    public $clearUrl;


    public function run()
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