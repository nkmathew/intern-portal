<?php

/* @var $this yii\web\View */
/* @var $signupLink app\models\User */

$signupUrl = Yii::$app->urlManager->createAbsoluteUrl(['site/signup-thru-link', 'signup_token' => $signupLink->signup_token]);
?>

Hello <?= $signupLink->email ?>,
Follow the link below to reset your password:
<?= $signupUrl ?>
