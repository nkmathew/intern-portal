<?php

/* @var $this yii\web\View */

use app\models\ProfileForm;
use yii\bootstrap\Tabs;

$this->title = 'Home';
?>

<title>Home</title> <!-- For Pjax's sake -->
<div class="site-index">
    <?php
    $tabItems = [
        [
            'label' => '<span class="glyphicon glyphicon-user"></span> Profile',
            'content' => $this->render('profile', ['model' => new ProfileForm()]),
            'headerOptions' => ['id' => 'profile-tab'],
            'active' => true
        ],
        [
            'label' => '<span class="glyphicon glyphicon-book"></span> Log Book',
            'content' => $this->render('logbook'),
            'headerOptions' => ['id' => 'logbook-tab'],
            'options' => ['id' => 'tab-logbook'],
        ],
        [
            'label' => '<span class="glyphicon glyphicon-inbox"></span> Notifications',
            'content' => $this->render('notifications'),
            'headerOptions' => ['id' => 'notifications-tab'],
            'options' => ['id' => 'tab-notifications'],
        ],
    ];
    if (!Yii::$app->user->isGuest) {
        $tabItems[] = [
            'label' => '<span class="glyphicon glyphicon-console"></span> Coordinator\'s Console',
            'content' => $this->render('coordinatorConsole'),
            'headerOptions' => ['id' => 'coordinator-console-tab'],
            'options' => ['id' => 'tab-coordinator-console'],
        ];
    }
    echo Tabs::widget(['encodeLabels' => false, 'items' => $tabItems]);
    ?>
</div>
