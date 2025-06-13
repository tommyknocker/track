<?php

namespace app\modules\api\controllers;

use app\models\Track;
use Yii;
use yii\rest\Controller;

class TrackController extends Controller
{
    public function verbs(): array
    {
        return [
            'index' => ['get'],
            'get' => ['get'],
            'create' => ['post'],
            'update' => ['patch'],
            'delete' => ['delete'],
            'change-status' => ['post'],
        ];
    }

    public function actionIndex()
    {
        $status = Yii::$app->request->get('status');
        return Track::find()
            ->orderBy(['id' => SORT_ASC])
            ->andFilterWhere(['status' => $status])
            ->all();
    }

    public function actionGet($id)
    {
        $model = Track::findOne($id);
        if($model) {
            return $model;
        }
        return ['result' => 'error', 'errors' => ['Track not found']];
    }

    public function actionCreate()
    {
        $model = new Track();
        if($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ['result' => 'ok'];
        }
        return ['result' => 'error', 'errors' => $model->errors];
    }

    public function actionUpdate()
    {
        $model = new Track();
        if($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ['result' => 'ok'];
        }
        return ['result' => 'error', 'errors' => $model->errors];
    }

    public function actionDelete($id)
    {
        $model = Track::findOne($id);
        if(!$model) {
            return ['result' => 'error', 'errors' => ['Track not found']];
        }
        $result = $model->delete();
        if(!$result) {
            return ['result' => 'error', 'errors' => $model->errors];
        }
        return ['result' => 'ok'];
    }

    public function actionChangeStatus()
    {
        $id = Yii::$app->request->post('id');
        $status = Yii::$app->request->post('status');
        $result = Track::updateAll(['status' => $status], ['id' => $id]);
        if($result) {
            return ['result' => 'ok'];
        } else {
            return ['result' => 'error', 'errors' => 'No models updated'];
        }
    }
}