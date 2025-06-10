<?php

use app\models\Track;
use app\widgets\SearchButtons;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrackSearch */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="track-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'id') ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'track_number') ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'status')->widget(Select2::class, [
                'data' => Track::getStatusList(),
                'options' => [
                    'placeholder' => 'Выберите ...',
                    'allowClear' => true,
                ]
            ]) ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'created_at')->widget(DatePicker::class) ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'updated_at')->widget(DatePicker::class) ?>
        </div>

    </div>

    <?= SearchButtons::widget() ?>

    <?php ActiveForm::end(); ?>

</div>
