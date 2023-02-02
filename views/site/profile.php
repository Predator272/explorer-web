<?php

use yii\bootstrap4\Html;

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-body">
        <h1 class="card-title"><?= $model->login ?></h1>
        <p class="card-text"><?= $model->rule == 0 ? 'Пользователь' : 'Администратор' ?></p>
    </div>
</div>