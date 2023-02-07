<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>
        <?php
        NavBar::begin([
            'brandLabel' => Html::img(['/favicon.ico'], ['class' => 'mr-2', 'width' => 24, 'height' => 24]) . Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'brandOptions' => ['class' => 'd-flex align-items-center'],
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-light bg-light fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ml-auto'],
            'items' => [
                ['label' => 'Главная', 'url' => Yii::$app->homeUrl],
                ['label' => 'Вход', 'url' => ['/site/signin'], 'visible' => Yii::$app->user->isGuest == true],
                ['label' => 'Регистрация', 'url' => ['/site/signup'], 'visible' => Yii::$app->user->isGuest == true],
                [
                    'label' => Yii::$app->user->identity->login,
                    'items' => [
                        ['label' => 'Профиль', 'url' => ['/site/profile']],
                        ['label' => 'Выход', 'url' => ['/site/signout'], 'linkOptions' => ['data' => ['method' => 'POST']]],
                    ],
                    'visible' => Yii::$app->user->isGuest == false
                ]
            ]
        ]);
        NavBar::end();
        ?>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs'], 'options' => ['class' => 'bg-transparent p-0']]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-left">&copy; My Company <?= date('Y') ?></p>
            <p class="float-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>