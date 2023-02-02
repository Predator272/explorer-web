<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\File;

$this->title = 'Файлы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-body">
        <h1 class="card-title"><?= Html::encode($this->title) ?></h1>
        <?php $form = ActiveForm::begin(['action' => 'create']); ?>
        <?= $form->field(new File(), 'file', ['template' => '{label}{input}', 'options' => ['class' => 'mb-3']])->fileInput(['hidden' => true, 'onchange' => 'this.form.submit()'])->label(null, ['class' => 'btn btn-success m-0 w-100']) ?>
        <?php ActiveForm::end(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'options' => ['class' => 'grid-view table-responsive'],
            'tableOptions' => ['class' => 'table table-hover m-0'],
            'headerRowOptions' => ['class' => 'border-bottom'],
            'rowOptions' => function ($model, $index, $key) {
                return ['class' => 'border-top', 'ondblclick' => 'window.location.assign("' . Url::to(['view', 'id' => $model->id]) . '")'];
            },
            'pager' => [
                'maxButtonCount' => 5,
                'options' => ['class' => 'pagination justify-content-center m-0 mt-3'],
                'disabledListItemSubTagOptions' => ['class' => 'page-link disabled'],
                'linkContainerOptions' => ['class' => 'page-item'],
                'linkOptions' => ['class' => 'page-link'],
                'firstPageLabel' => 'Первая',
                'prevPageLabel' => 'Предыдущая',
                'nextPageLabel' => 'Следующая',
                'lastPageLabel' => 'Последняя',
            ],
            'columns' => [
                [
                    'headerOptions' => ['class' => 'border-0'],
                    'contentOptions' => ['class' => 'border-0'],
                    'attribute' => 'name',
                ],
                [
                    'headerOptions' => ['class' => 'border-0'],
                    'contentOptions' => ['class' => 'border-0'],
                    'attribute' => 'onUpdate',
                ],
                [
                    'headerOptions' => ['class' => 'border-0'],
                    'contentOptions' => ['class' => 'border-0'],
                    'attribute' => 'user',
                    'value' => 'user0.login',
                ],
            ],
        ]) ?>
    </div>
</div>