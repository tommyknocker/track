<?php

/** @var yii\web\View $this */
/** @var User $user */

use app\models\User;

$this->title = 'Track';
?>
<div class="site-index">
    <?php if($user) { ?>
        <p>Ваш токен для апи: <b style="color:red;"><?=$user->access_token?></b></p>
    <?php } ?>
    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Тестовое задание</h1>
    </div>

</div>
