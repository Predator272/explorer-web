<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Signin;
use app\models\User;
use app\models\FileSearch;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'signup', 'signin', 'signout', 'profile'],
                'rules' => [
                    [
                        'actions' => ['signup', 'signin'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'signout', 'profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'signout' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new FileSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination->pageSize = 10;
        return $this->render('index', compact('searchModel', 'dataProvider'));
    }

    public function actionSignup()
    {
        $model = new User();
        if ($model->load($this->request->post()) && $model->save() && Yii::$app->user->login($model, 3600 * 24 * 30)) {
            return $this->goHome();
        } else {
            $model->loadDefaultValues();
        }
        return $this->render('signup', compact('model'));
    }

    public function actionSignin()
    {
        $model = new Signin();
        if ($model->load($this->request->post()) && $model->signin()) {
            return $this->goHome();
        }
        $model->password = '';
        return $this->render('signin', compact('model'));
    }

    public function actionSignout()
    {
        $this->user->logout();
        return $this->goHome();
    }

    public function actionProfile()
    {
        $model = Yii::$app->user->identity;
        return $this->render('profile', compact('model'));
    }
}
