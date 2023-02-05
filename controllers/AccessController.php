<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Access;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class AccessController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionCreate($file)
    {
        $model = new Access(['file' => $file]);
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
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['/file/index', 'id' => $model->file0->id]);
        }
        return $this->render('update', compact('model'));
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect($this->request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = Access::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Страница не найдена.');
    }
}
