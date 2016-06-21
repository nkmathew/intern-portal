<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap\Nav;
use yii\widgets\Pjax;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <link rel="icon" href="/favicon.ico?"/>
        <style type="text/css" media="all">
            .navbar-brand {
                padding: 0px;
            }
            .navbar-brand img {
                height: 50px;
            }
        </style>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => Html::img('/favicon.png'),
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                '<li>' . Html::a('Home', '/site/index', ['id' => 'link-index']) . '</li>',
                '<li>' . Html::a('About', '/site/about', ['id' => 'link-about']) . '</li>',
                '<li>' . Html::a('Contact', '/site/contact', ['id' => 'link-contact']) . '</li>',
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] =
                '<li>' . Html::a('Signup', '/site/signup', ['id' => 'link-signup']) . '</li>' .
                '<li>' . Html::a('Login', '/site/login', ['id' => 'link-login']) . '</li>';
            } else {
                $menuItems[] = '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->email . ')',
                        ['class' => 'btn btn-link']
                    )
                    . Html::endForm()
                    . '</li>';
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();

            // Make content load silently with Pjax
            Pjax::widget(['id' => "main-content-area", "linkSelector" => "#link-index"]);
            Pjax::widget(['id' => "main-content-area", "linkSelector" => "#link-about"]);
            Pjax::widget(['id' => "main-content-area", "linkSelector" => "#link-contact"]);
            Pjax::widget(['id' => "main-content-area", "linkSelector" => "#link-signup"]);
            Pjax::widget(['id' => "main-content-area", "linkSelector" => "#link-login"]);
            ?>
            <div class="container">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <div id="main-content-area">
                    <?= $content ?>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; Jomo Kenyatta University of Agriculture and Technology <?= date('Y') ?></p>
            </div>
        </footer>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
