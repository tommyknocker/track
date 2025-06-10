<?php

use app\components\grid\ActionColumn;
use app\components\grid\DateColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ActionLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Действия';
$this->params['breadcrumbs'][] = 'Логи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="action-log-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_search', ['model' => $searchModel]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            'id',
            'entity',
            'entity_id',
            [
                'attribute' => 'action_id',
                'value' => 'actionName'
            ],
            [
                'attribute' => 'user_id',
                'value' => 'userName'
            ],
            ['class' => DateColumn::class],
            [
                'class' => ActionColumn::class,
                'visibleButtons' => [
                    'update' => false,
                    'delete' => false
                ]
            ]
        ],
    ]) ?>
</div>
