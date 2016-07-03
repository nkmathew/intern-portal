<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $signupLink app\models\SignupLinks */

$signupUrl = Yii::$app->urlManager->createAbsoluteUrl(['site/link-signup', 'signup_token' => $signupLink->signup_token]);
?>

<style>
    body {
        font-family: Verdana;
        font-size: 14px;
    }
    a,strong {
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
</style>

<div class="password-reset">
    <p>Hello <strong><?= Html::encode($signupLink->email) ?></strong>,</p>
    <p>Follow the link below to signup:</p>
    <p><?= Html::a(Html::encode($signupUrl), $signupUrl) ?></p>
    <footer>Regards,<br>Intern Portal Team</footer>
</div>
