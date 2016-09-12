<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $assocLink app\models\AssociationLinks */

$assocUrl = Yii::$app->urlManager->createAbsoluteUrl(['site/accept-association', 'assoc_token' => $assocLink->token]);
?>

<div class="password-reset">
    <p>Hello <strong><?= Html::encode($assocLink->intern0->profile->surname) ?></strong>,</p>
    A supervisor by the name <strong><?= $assocLink->supervisor0->supervisorprofile->fullName() ?></strong>
    is requesting access to your logbook
    <p>Follow the link below to grant access:</p>
    <p><?= Html::a(Html::encode($assocUrl), $assocUrl) ?></p>
    <footer>Regards,<br>Intern Portal Team</footer>
</div>
