<?php

use app\models\ActionLog;
use app\models\User;
use app\widgets\SearchButtons;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ActionLogSearch */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="action-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'entity') ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'entity_id') ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'action_id')->widget(Select2::class, [
                'data' => ActionLog::getActionList(),
                'options' => [
                    'placeholder' => 'Выберите ...',
                    'allowClear' => true,
                ]
            ]) ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'user_id')->widget(Select2::class, [
                'data' => User::getList(),
                'options' => [
                    'placeholder' => 'Выберите ...',
                    'allowClear' => true,
                ]
            ]) ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'created_at')->widget(DatePicker::class) ?>
        </div>
    </div>

    <?= SearchButtons::widget() ?>

    <?php ActiveForm::end(); ?>

</div>
