<?php

namespace app\modules\api;

use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;

/**
 * api module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\api\controllers';

    public function behaviors(): array
    {
        return [
            'authenticator' => [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    HttpBearerAuth::class,
                ],
                'except' => [
                    'track/index',
                    'track/get',
                ],
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();
        Yii::$app->response->format = Response::FORMAT_JSON;
    }
}
