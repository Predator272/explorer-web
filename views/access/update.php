<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;

$this->title = 'Редактировать правило для ' . $model->user0->login;
$this->params['breadcrumbs'][] = ['label' => $model->file0->name, 'url' => ['/file/index', 'id' => $model->file0->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <h3 class="card-header"><?= Html::encode($this->title) ?></h3>
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'user')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'login')) ?>
        <?= $form->field($model, 'rule')->dropDownList($model->rules) ?>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>