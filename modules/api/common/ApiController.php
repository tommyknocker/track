<?php

namespace app\modules\api\common;

use yii\filters\Cors;
use yii\rest\Controller;
use yii\web\Response;

class ApiController extends Controller {

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON,
            'text/html' => Response::FORMAT_JSON,
            'text/plain' => Response::FORMAT_JSON,
            'application/octet-stream' => Response::FORMAT_JSON,
        ];
        return $behaviors;
    }
}