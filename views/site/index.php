<?php

use yii\bootstrap4\Html;

$this->title = Yii::$app->name;
?>
<?= Html::a('Файлы', ['/file/index'], ['class' => 'btn btn-primary']) ?>