<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Track $model */

$this->title = 'Добавить трек';
$this->params['breadcrumbs'][] = ['label' => 'Треки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="track-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
