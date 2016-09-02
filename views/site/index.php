<?php

/* @var $this yii\web\View */

use app\models\ProfileForm;
use app\models\Profile;
use yii\bootstrap\Tabs;
use app\controllers\SiteController;

$this->title = 'Home';

$email = Yii::$app->user->identity->email;
$profile = Profile::findByEmail($email);

$userRole = Yii::$app->user->identity->role;

?>

<title>Home</title> <!-- For Pjax's sake -->
<div class="site-index">
    <?php
    $tabItems = [];
    if ($userRole == 'supervisor') {
        $tabItems[] = [
            'label' => '<span class="glyphicon glyphicon-console"></span> Coordinator\'s Console',
            'content' => $this->render('coordinatorConsole'),
            'headerOptions' => ['id' => 'coordinator-console-tab', 'class' => 'tab-main'],
            'options' => ['id' => 'tab-coordinator-console'],
        ];
    } else if ($userRole == 'superuser') {
        $tabItems = [
            [
            'label' => '<span class="glyphicon glyphicon-trash"></span> Account Deletion',
            'content' => $this->render('admin/accountDeletion'),
            'headerOptions' => ['id' => 'account-deletion-tab', 'class' => 'tab-main'],
            'options' => ['id' => 'tab-account-deletion'],
            ]
        ];
    } else if ($userRole == 'intern') {
        $tabItems = [
            [
                'label' => '<span class="glyphicon glyphicon-user"></span> Profile',
                'content' => $this->context->actionProfile(true),
                'headerOptions' => ['id' => 'profile-tab', 'class' => 'tab-main'],
            ]
        ];
        if ($profile->duration) {
            $moreItems = [
                [
                    'label' => '<span class="glyphicon glyphicon-book"></span> Log Book',
                    'content' => $this->render('logbook'),
                    'headerOptions' => ['id' => 'logbook-tab', 'class' => 'tab-main'],
                    'options' => ['id' => 'tab-logbook'],
                ],
                [
                    'label' => '<span class="glyphicon glyphicon-stats"></span> Progress',
                    'content' => $this->context->actionProgress(),
                    'headerOptions' => ['id' => 'progress-tab', 'class' => 'tab-main'],
                    'options' => ['id' => 'tab-progress'],
                ],
                [
                    'label' => '<span class="glyphicon glyphicon-list-alt"></span> Preview',
                    'content' => $this->render('preview'),
                    'headerOptions' => ['id' => 'preview-tab', 'class' => 'tab-main'],
                    'options' => ['id' => 'tab-preview'],
                ]
            ];
            $tabItems = array_merge_recursive($moreItems, $tabItems);
        }
    }
    if (!$profile->duration && $userRole == 'intern') {
        Yii::$app->session->setFlash('error', 'Please save the start date and duration of your internship first');
    }
    echo Tabs::widget(['encodeLabels' => false, 'items' => $tabItems]);
    ?>
</div>
