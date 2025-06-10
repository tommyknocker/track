<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Alert;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $model app\models\RecoveryForm */
/* @var $tokenFailure bool */


$this->title = 'Восстановление пароля';
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

<?php if ($tokenFailure): ?>
    <?= Alert::widget([
        'body' => 'Токен не найден или закончился срок его действия',
        'closeButton' => false,
        'options' => ['class' => 'alert-danger']
    ]) ?>

    <a class="recovery-link" href="/login"><?= 'Войти' ?></a>
<?php else: ?>

    <?= $form->field($model, 'password')->passwordInput([
        'autofocus' => true,
        'placeholder' => 'Новый пароль'
    ])->label(false) ?>

    <?= $form->field($model, 'passwordRepeat')
        ->passwordInput(['placeholder' => 'Повторить пароль'])->label(false) ?>


    <div class="form-group">
        <?= Html::submitButton('Отправить',
            ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>
    </div>

<?php endif; ?>

<?php ActiveForm::end(); ?>
