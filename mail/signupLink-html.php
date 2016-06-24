<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $signupLink app\models\SignupLinks */

$signupUrl = Yii::$app->urlManager->createAbsoluteUrl(['site/signup-thru-link', 'token' => $signupLink->signup_token]);
?>

<div class="password-reset">
    <p>Hello <strong><?= Html::encode($signupLink->email) ?></strong>,</p>
    <p>Follow the link below to signup:</p>
    <p><?= Html::a(Html::encode($signupUrl), $signupUrl) ?></p>
    <footer>Regards,<br>Intern Portal Team</footer>
</div>
