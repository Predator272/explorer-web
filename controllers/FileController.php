<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;
use app\models\File;
use app\models\AccessSearch;

class FileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['POST'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex($id)
    {
        $model = $this->findModel($id);
        if (!$model->canView) {
            throw new ForbiddenHttpException('Вам не разрешено производить данное действие.');
        }
        $searchModel = new AccessSearch(['file' => $model->id]);
        $dataProvider = $searchModel->search($this->request->queryParams);
        if ($this->request->isPost) {
            if (!$model->canUpdate) {
                throw new ForbiddenHttpException('Вам не разрешено производить данное действие.');
            }
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Сохранено.');
            } else {
                Yii::$app->session->setFlash('error', 'Неудалось сохранить изменения.');
            }
        }
        return $this->render('index', compact('model', 'searchModel', 'dataProvider'));
    }

    public function actionDownload($id)
    {
        $model = $this->findModel($id);
        if (!$model->canView) {
            throw new ForbiddenHttpException('Вам не разрешено производить данное действие.');
        }
        if (is_file($model->filePath)) {
            return $this->response->sendFile($model->filePath, $model->name);
        }
        throw new ServerErrorHttpException('Неудалось найти файл.');
    }

    public function actionCreate()
    {
        if ($this->request->isPost) {
            if ($file = UploadedFile::getInstanceByName('file')) {
                $model = new File(['name' => $file->name, 'user' => Yii::$app->user->identity->id]);
                if ($model->validate()) {
                    if ($model->save() && $file->saveAs($model->filePath)) {
                        Yii::$app->session->setFlash('success', 'Файл успешно загружен.');
                    } else {
                        Yii::$app->session->setFlash('error', 'Неудалось загрузить файл.');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Файл с таким именем уже существует.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Выберите файл.');
            }
        }
        return $this->redirect($this->request->referrer);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (!$model->canDelete) {
            throw new ForbiddenHttpException('Вам не разрешено производить данное действие.');
        }
        if (is_file($model->filePath)) {
            unlink($model->filePath);
        }
        $model->delete();
        return $this->goHome();
    }

    protected function findModel($id)
    {
        if (($model = File::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Страница не найдена.');
    }
}
