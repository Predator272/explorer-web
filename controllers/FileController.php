<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use app\models\File;
use app\models\FileSearch;
use app\models\AccessSearch;

class FileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return $this->findModel($this->request->get('id'))->canUpdate;
                        }
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return $this->findModel($this->request->get('id'))->canDelete;
                        }
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

    public function actionCreate()
    {
        $model = new File();
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Файл успешно загружен.');
            } else {
                Yii::$app->session->setFlash('error', 'Неудалось загрузить файл.');
            }
        } else {
            $model->loadDefaultValues();
        }
        return $this->redirect($this->request->referrer);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModel = new AccessSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('view', compact('model', 'searchModel', 'dataProvider'));
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect($this->request->referrer);
        }
        return $this->render('update', compact('model'));
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->goHome();
    }

    public function actionDownload($id)
    {
        $model = $this->findModel($id);
        if (is_file($model->filePath)) {
            return $this->response->sendFile($model->filePath, $model->name);
        }
        throw new ServerErrorHttpException('Неудалось найти файл.');
    }

    protected function findModel($id)
    {
        if (($model = File::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
