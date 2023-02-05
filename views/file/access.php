<?php

use yii\bootstrap4\Html;

$this->title = 'Настройки доступа';
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card mb-3">
    <div class="card-header">
        <h3 class="m-0"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="card-body">
        <p class="card-text">Владелец: <?= $model->user0->login ?></p>
        <p class="card-text">Дата создания: <?= $model->onUpdate ?></p>
    </div>
</div>