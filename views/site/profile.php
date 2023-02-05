<?php

use yii\bootstrap4\Html;

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <h3 class="card-header"><?= Html::encode($this->title) ?></h3>
    <div class="card-body">
        <h3 class="card-title"><?= $model->login ?></h3>
        <p class="card-text"><?= $model->rule == 0 ? 'Пользователь' : 'Администратор' ?></p>
    </div>
</div>