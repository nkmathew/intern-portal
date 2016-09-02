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

$userRole = Yii::$app->user->identity->role;

$roleLabel = 'Intern';
$navbarClass = 'navbar-default navbar-fixed-top';
if ($userRole == 'supervisor') {
    $roleLabel = 'Intern Supervisor';
    $navbarClass = 'navbar-supervisor navbar-fixed-top';
} else {
    $roleLabel = 'Portal Administrator';
    $navbarClass = 'navbar-administrator navbar-fixed-top';
}

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title>Intern Portal :: <?= Html::encode($this->title) ?></title>
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
            $logoImage = '<img src="/jkuat-logo.png" style="display:inline" title="JKUAT Intern Portal">';
            NavBar::begin([
                'brandLabel' => "$logoImage <span>$roleLabel</span>",
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => $navbarClass,
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
                $email = Yii::$app->user->identity->email;
                $username = explode('@', $email)[0];
                $menuItems[] = '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Logout (<span title="'
                        . $email . '">'
                        . $username
                        . '</span>)',
                        ['class' => 'btn-logout btn btn-link']
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
            Pjax::widget(['id' => "main-content-area", "linkSelector" => "#link-pwd-reset"]);
            ?>
            <div class="container">
                <?= Alert::widget() ?>
                <div id="main-content-area">
                    <div id="alert-box" class="alert-box alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <span class="msg"></span>
                    </div>
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
