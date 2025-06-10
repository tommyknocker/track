<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $model app\models\RegistrationForm */

$this->title = 'Регистрация в' . ' ' . Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'id' => 'register-form',
    'options' => [
        'class' => 'form-signin'
    ],

]); ?>

<a href="/">Track</a>

<h4 class="h4 mb-3 font-weight-normal"><?= Html::encode($this->title) ?></h4>


<?= $form->field($model, 'phone')->textInput([
    'autofocus' => true,
    'placeholder' => 'Телефон'
])->label(false) ?>

<?= $form->field($model, 'email')->textInput(['placeholder' => 'Email'])->label(false) ?>

<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль'])->label(false) ?>


<div class="form-group">
    <?= Html::submitButton('Зарегистрироваться',
        ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>
</div>

<?php ActiveForm::end(); ?>