<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="m-0"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'login')->textInput(['autofocus' => true, 'maxlength' => true]) ?>
                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>