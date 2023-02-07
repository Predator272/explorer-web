<?php

namespace app\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use app\models\Access;
use app\models\File;

class AccessController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCreate($file)
    {
        $fileModel = $this->findFileModel($file);
        if (!$fileModel->canDelete) {
            throw new ForbiddenHttpException('Вам не разрешено производить данное действие.');
        }
        $model = new Access(['file' => $fileModel->id]);
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['/file/index', 'id' => $model->file0->id]);
            }
        } else {
            $model->loadDefaultValues();
        }
        return $this->render('create', compact('model'));
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (!$model->file0->canDelete) {
            throw new ForbiddenHttpException('Вам не разрешено производить данное действие.');
        }
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['/file/index', 'id' => $model->file0->id]);
        }
        return $this->render('update', compact('model'));
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (!$model->file0->canDelete) {
            throw new ForbiddenHttpException('Вам не разрешено производить данное действие.');
        }
        $model->delete();
        return $this->redirect($this->request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = Access::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Страница не найдена.');
    }

    protected function findFileModel($id)
    {
        if (($model = File::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Страница не найдена.');
    }
}
