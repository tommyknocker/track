<?php

use app\components\grid\ActionColumn;
use app\components\grid\DateColumn;
use app\models\Track;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TrackSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Треки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="track-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить трек', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'track_number',
            [
                'attribute' => 'status',
                'filter' => Track::getStatusList(),
                'value' => function ($model) {
                    return Track::getStatusList()[$model->status];
                }
            ],
            ['class' => DateColumn::class],
            [
                'class' => ActionColumn::class,
                'visibleButtons' => [
                    'view' => false,
                ]
            ]
        ],
    ]); ?>


</div>
