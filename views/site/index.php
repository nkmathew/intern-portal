<?php

/* @var $this yii\web\View */

use app\models\ProfileForm;
use yii\bootstrap\Tabs;

$this->title = 'Home';
?>

<title>Home</title> <!-- For Pjax's sake -->
<div class="site-index">
    <?=
    Tabs::widget([
        'encodeLabels' => false,
        'items' => [
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
        ],
    ]);
    ?>
</div>
