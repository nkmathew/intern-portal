<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
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
    <p>Hello <?= Html::encode($user->email) ?>,</p>
    <p>Follow the link below to reset your password:</p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
