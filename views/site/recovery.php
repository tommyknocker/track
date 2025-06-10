<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Alert;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $model app\models\RecoveryForm */
/* @var $success bool */


$this->title ='Восстановление пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin([
    'id' => 'recovery-form',
    'options' => [
        'class' => 'form-signin'
    ],
]); ?>
    <a href="/">Track</a>

    <h1 class="h3 mb-3 font-weight-normal"><?= Html::encode($this->title) ?></h1>

<?php if ($success): ?>
    <?= Alert::widget([
        'body' => 'Сообщение успешно отправлено. Проверьте ваш почтовый ящик',
        'closeButton' => false,
        'options' => ['class' => 'alert-success']
    ]) ?>
<?php else: ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Email'])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить',
            ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>
    </div>

    <a class="recovery-link" href="/login"><?= 'Войти' ?></a>
<?php endif ?>

<?php ActiveForm::end(); ?>