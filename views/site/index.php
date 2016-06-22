<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use app\models\ProfileForm;

$this->title = 'Home';
?>

<title>Home</title> <!-- For Pjax's sake -->
<div class="site-index">
<?=
Tabs::widget([
    'items' => [
        [
            'label' => 'Profile',
            'content' => $this->render('profile', ['model' => new ProfileForm()]),
            'headerOptions' => ['id' => 'profile-tab'],
            'active' => true
        ],
        [
            'label' => 'Log Book',
            'content' => $this->render('logbook'),
            'headerOptions' => ['id' => 'logbook-tab'],
            'options' => ['id' => 'tab-logbook'],
        ],
        [
            'label' => 'Notifications',
            'content' => $this->render('notifications'),
            'headerOptions' => ['id' => 'notifications-tab'],
            'options' => ['id' => 'tab-notifications'],
        ],
    ],
]);
?>
</div>
