<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Access $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="access-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'file')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rule')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
