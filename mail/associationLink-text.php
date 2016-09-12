<?php

/* @var $this yii\web\View */
/* @var $assocLink app\models\AssociationLinks */

$assocUrl = Yii::$app->urlManager->createAbsoluteUrl(['site/accept-association', 'assoc_token' => $assocLink->token]);
?>

Hello <?= $assocLink->intern0->profile->surname ?>,
A supervisor by the name <?= $assocLink->supervisor0->supervisorprofile->fullName() ?> is requesting access to your logbook
Follow the link below to grant access:
<?= $assocUrl ?>

Regards,
Intern Portal Team
