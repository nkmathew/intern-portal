<?php

/* @var $this yii\web\View */

use app\models\Profile;
use yii\bootstrap\Tabs;

$this->title = 'Home';

$email = Yii::$app->user->identity->email;
$profile = Profile::findByEmail($email);

$thisUser = Yii::$app->user->identity;
$userRole = Yii::$app->user->identity->role;

?>

<title>Home</title> <!-- For Pjax's sake -->
<div class="site-index">
    <?php
    $tabItems = [];
    if (($userRole == 'coordinator') || ($userRole == 'supervisor')) {
        $tabItems = [
            [
                'label' => '<span class="glyphicon glyphicon-user"></span> Supervisor Profile',
                'content' => $this->context->actionSupervisorProfile(),
                'headerOptions' => ['id' => 'profile-tab', 'class' => 'tab-main'],
            ]
        ];
        if ($thisUser->supervisorprofile->id_number) {
            $moreItems = [
                [
                    'label' => '<span class="glyphicon glyphicon-console"></span> Coordinator Console',
                    'content' => $this->render('coordinatorConsole'),
                    'headerOptions' => ['id' => 'coordinator-console-tab', 'class' => 'tab-main'],
                    'options' => ['id' => 'tab-coordinator-console']
                ],
                [
                    'label' => '<span class="glyphicon glyphicon-list"></span> Reviews',
                    'content' => $this->context->actionReviews(),
                    'headerOptions' => ['id' => 'supervisor-reviews-tab', 'class' => 'tab-main'],
                    'options' => ['id' => 'tab-supervisor-reviews']
                ],
            ];
            if ($userRole == 'supervisor') {
                $config = [
                    'label' => '<span class="glyphicon glyphicon-cog"></span> Configuration',
                    'content' => $this->context->actionConfigForm(),
                    'headerOptions' => ['id' => 'config-tab', 'class' => 'tab-main'],
                    'options' => ['id' => 'tab-config']
                ];
                $tabItems[] = $config;
            }
            $tabItems = array_merge_recursive($tabItems, $moreItems);
        } else {
            Yii::$app->session->setFlash('error', 'Update your profile first to be able to access the other functions');
        }
    } else if ($userRole == 'superuser') {
        $tabItems = [
            [
                'label' => '<span class="glyphicon glyphicon-trash"></span> Account Deletion',
                'content' => $this->render('admin/accountDeletion'),
                'headerOptions' => ['id' => 'account-deletion-tab', 'class' => 'tab-main'],
                'options' => ['id' => 'tab-account-deletion'],
            ],
            [
                'label' => '<span class="glyphicon glyphicon-console"></span> Invite Supervisors',
                'content' => $this->render('admin/adminConsole'),
                'headerOptions' => ['id' => 'admin-console-tab', 'class' => 'tab-main'],
                'options' => ['id' => 'tab-admin-console'],
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
                ],
                [
                    'label' => '<span class="glyphicon glyphicon-list"></span> Overview',
                    'content' => $this->context->actionReviewIntern(),
                    'headerOptions' => ['id' => 'overview-tab', 'class' => 'tab-main'],
                    'options' => ['id' => 'tab-overview'],
                ]
            ];
            $tabItems = array_merge_recursive($tabItems, $moreItems);
        } else {
            Yii::$app->session->setFlash('error', 'Please save the start date and duration of your internship first');
        }
    }
    echo Tabs::widget(['encodeLabels' => false, 'items' => $tabItems]);
    ?>
</div>
