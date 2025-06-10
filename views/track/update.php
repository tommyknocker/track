<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Track $model */

$this->title = 'Обновить трек: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Треки', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="track-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
