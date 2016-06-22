<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\Tabs;

$this->title = 'Home';
?>

<title>Home</title> <!-- For Pjax's sake -->
<div class="site-index">
<?=
Tabs::widget([
    'items' => [
        [
            'label' => 'Profile',
            'content' => $this->render('profile'),
            'active' => true
        ],
        [
            'label' => 'Notifications',
            'content' => $this->render('notifications'),
            'headerOptions' => [],
            'options' => ['id' => 'tab-notifications'],
        ],
    ],
]);
?>
</div>
