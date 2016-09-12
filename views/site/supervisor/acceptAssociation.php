<?php

/**
 * Project: Intern Portal.
 * User: nkmathew
 * Date: 12/09/2016
 * Time: 22:28
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $assocLink app\models\AssociationLinks */

$this->title = 'Accept association request';
$supervisorName = $assocLink->supervisor0->supervisorprofile->fullName();
$supervisorEmail = $assocLink->supervisor0->supervisorprofile->email;

?>

<div class="site-acceptAssociation">
    <?php $form = ActiveForm::begin([
        'action' => "/site/accept-association?assoc_token=$assocLink->token"
    ]); ?>
       <?= Html::csrfMetaTags() ?>

       You are about to assign <div class="bitalics"><?= $supervisorName ?></div> with email,
       <div class="bitalics"><?= $supervisorEmail ?></div> as your supervisor hence granting him
       access to your logbook and reponsibility to review your progress. Click <em>Confirm</em> to
       accept and <em>Reject</em> to ignore this request <br>
       <button class="btn btn-success" type="submit" name="response" value="1">Confirm </button>
    <button class="btn btn-danger" type="submit" name="response" value="0">Reject </button>
    <?php ActiveForm::end(); ?>
</div>
