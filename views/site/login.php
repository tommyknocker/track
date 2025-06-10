<?php

use app\models\LoginForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Alert;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $model app\models\LoginForm */
/* @var $passwordReset bool */


$this->title = 'Войти в' . ' ' . Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => [
        'class' => 'form-signin'
    ],
]); ?>

<a href="/">Track</a>

<h1 class="h3 mb-3 font-weight-normal"><?= Html::encode($this->title) ?></h1>

<?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Email'])->label(false) ?>

<?= $form->field($model, 'password')->passwordInput(['placeholder' =>'Пароль'])->label(false) ?>

<div class="form-group">
    <?= Html::submitButton('Войти',
        ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>
</div>

<?= $form->field($model, 'rememberMe')->checkbox() ?>


<p>
    <a class="recovery-link text-muted" style="font-size: 11px"
       href="/recovery"><?= 'Забыли пароль?' ?></a>
</p>

<p>
    <a class="recovery-link text-muted" style="font-size: 11px" href="/register"><?='Регистрация' ?></a>
</p>

<?php ActiveForm::end(); ?>
