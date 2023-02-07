<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

$this->title = Yii::$app->name;
?>
<div class="card">
    <h3 class="card-header">Файлы</h3>
    <div class="card-body">
        <?= Html::beginForm(['/file/create'], 'post', ['enctype' => 'multipart/form-data', 'class' => 'mb-3']) ?>
        <div class="custom-file">
            <?= Html::fileInput('file', null, ['class' => 'custom-file-input', 'id' => 'file-file', 'onchange' => 'this.form.submit()']) ?>
            <?= Html::label('Файл', 'file-file', ['class' => 'custom-file-label']) ?>
        </div>
        <?= Html::endForm() ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'options' => ['class' => 'grid-view table-responsive'],
            'tableOptions' => ['class' => 'table m-0'],
            'headerRowOptions' => ['class' => 'border-bottom'],
            'rowOptions' => ['class' => 'border-top'],
            'pager' => [
                'maxButtonCount' => 6,
                'options' => ['class' => 'pagination justify-content-center m-0 mt-3'],
                'disabledListItemSubTagOptions' => ['class' => 'page-link disabled'],
                'linkContainerOptions' => ['class' => 'page-item'],
                'linkOptions' => ['class' => 'page-link'],
                'firstPageLabel' => '&laquo;',
                'prevPageLabel' => '&lsaquo;',
                'nextPageLabel' => '&rsaquo;',
                'lastPageLabel' => '&raquo;',
            ],
            'columns' => [
                [
                    'headerOptions' => ['class' => 'border-0'],
                    'contentOptions' => ['class' => 'border-0 align-middle'],
                    'attribute' => 'name',
                ],
                [
                    'headerOptions' => ['class' => 'border-0'],
                    'contentOptions' => ['class' => 'border-0 align-middle'],
                    'attribute' => 'onUpdate',
                ],
                [
                    'headerOptions' => ['class' => 'border-0'],
                    'contentOptions' => ['class' => 'border-0 align-middle'],
                    'attribute' => 'user',
                    'value' => 'user0.login',
                ],
                [
                    'headerOptions' => ['class' => 'border-0'],
                    'contentOptions' => ['class' => 'border-0 align-middle'],
                    'content' => function ($model) {
                        return Html::tag('div', ($model->canView ? Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                            </svg>', ['/file/download', 'id' => $model->id], ['class' => 'btn btn-outline-success d-flex justify-content-center align-items-center']) : '') .
                            ($model->canUpdate ? Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                            <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
                            </svg>', ['/file/index', 'id' => $model->id], ['class' => 'btn btn-outline-primary d-flex justify-content-center align-items-center']) : '') .
                            ($model->canDelete ? Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                            </svg>', ['/file/delete', 'id' => $model->id], ['class' => 'btn btn-outline-danger d-flex justify-content-center align-items-center', 'data' => ['confirm' => 'Вы действительно хотите удалить этот элемент?', 'method' => 'POST']]) : ''), ['class' => 'btn-group w-100']);
                    }
                ],
            ],
        ]) ?>
    </div>
</div>