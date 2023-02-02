<?php

use yii\bootstrap4\Html;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Файлы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-body">
        <h1 class="card-title">Файл: <?= $model->name ?></h1>
        <p class="card-text">Владелец: <?= $model->user0->login ?></p>
        <p class="card-text">Дата создания: <?= $model->onUpdate ?></p>
        <div class="row">
            <div class="col-auto">
                <?= Html::a('Скачать', ['download', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
            </div>
            <?php if ($model->canUpdate) : ?>
                <div class="col-auto">
                    <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                </div>
            <?php endif; ?>
            <?php if ($model->canDelete) : ?>
                <div class="col-auto">
                    <?= Html::a('Удалить', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger', 'data' => ['confirm' => 'Вы действительно хотите удалить этот элемент?', 'method' => 'POST']]) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>