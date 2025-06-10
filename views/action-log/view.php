<?php

use app\widgets\HighlightJs;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ActionLog */

$this->title = 'Просмотр действия №' . $model->id;
$this->params['breadcrumbs'][] = 'Логи';
$this->params['breadcrumbs'][] = ['label' => 'Действия', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="action-log-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'entity',
            'entity_id',
            [
                'attribute' => 'action_id',
                'value' => function ($model) {
                    return $model->actionName;
                }
            ],
            [
                'attribute' => 'user_id',
                'value' => function ($model) {
                    return  $model->userName;
                }
            ],
            'old_state:highlightJs',
            'new_state:highlightJs',
            'created_at:datetime',
        ],
    ]) ?>
</div>
