<?php

/* @var $this yii\web\View */

use app\models\ProfileForm;
use yii\bootstrap\Tabs;
use app\controllers\SiteController;

$this->title = 'Home';
?>

<title>Home</title> <!-- For Pjax's sake -->
<div class="site-index">
    <?php
    $tabItems = [
        [
            'label' => '<span class="glyphicon glyphicon-user"></span> Profile',
            'content' => $this->context->actionProfile(true),
            'headerOptions' => ['id' => 'profile-tab', 'class' => 'tab-main'],
        ],
        [
            'label' => '<span class="glyphicon glyphicon-book"></span> Log Book',
            'content' => $this->render('logbook'),
            'headerOptions' => ['id' => 'logbook-tab', 'class' => 'tab-main'],
            'options' => ['id' => 'tab-logbook'],
        ],
        [
            'label' => '<span class="glyphicon glyphicon-stats"></span> Progress',
            'content' => $this->render('progress'),
            'headerOptions' => ['id' => 'progress-tab', 'class' => 'tab-main'],
            'options' => ['id' => 'tab-progress'],
        ],
    ];
    $email = Yii::$app->user->identity->email;
    if (!Yii::$app->user->isGuest && !strchr($email, 'student')) {
        $tabItems[] = [
            'label' => '<span class="glyphicon glyphicon-console"></span> Coordinator\'s Console',
            'content' => $this->render('coordinatorConsole'),
            'headerOptions' => ['id' => 'coordinator-console-tab', 'class' => 'tab-main'],
            'options' => ['id' => 'tab-coordinator-console'],
        ];
    }
    echo Tabs::widget(['encodeLabels' => false, 'items' => $tabItems]);
    ?>
</div>
