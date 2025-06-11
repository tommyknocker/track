<?php

/** @var yii\web\View $this */

/** @var User $user */

use app\models\User;

$this->title = 'Track';
?>
<div class="site-index">
    <?php if ($user) { ?>
        <p>Ваш токен для апи: <b style="color:red;"><?= $user->access_token ?></b></p>
    <?php } ?>
    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Тестовое задание</h1>
    </div>
    <div class="">
        <h2>Методы API (endpoint http://hostname:port/api)</h2>
        <table class="table table-striped">
            <tr>
                <td>GET /track</td>
                <td>Получение списка треков. Возможна фильтрация по параметру status</td>
            </tr>
            <tr>
                <td>GET /track/:id</td>
                <td>Получение конкретного трека</td>
            </tr>
            <tr>
                <td>POST /track</td>
                <td>Создание трека</td>
            </tr>
            <tr>
                <td>PATCH /track/:id</td>
                <td>Изменение трека</td>
            </tr>
            <tr>
                <td>DELETE /track/:id</td>
                <td>Удаление трека</td>
            </tr>
            <tr>
                <td>POST /track/change-status</td>
                <td>Массовое изменение статусов.
                    Два параметра: <strong>id</strong> - список id для изменения,
                    <strong>status</strong> - статус для изменения
                </td>
            </tr>
        </table>
    </div>
</div>
