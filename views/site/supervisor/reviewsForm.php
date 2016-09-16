<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \app\models\SupervisorReviews */
/* @var $thisUser \app\models\User */
/* @var $form ActiveForm */

if ($model->reviewer0) {
    $role = $model->reviewer0->role;
}

?>

<style>
    .form-control {
        font-size: 16px;
    }
</style>

<div class="site-supervisor-reviewsForm">

    <?php $form = ActiveForm::begin([
        'action' => '/site/save-review',
        'id' => 'review-form',
        'validateOnSubmit' => true,
    ]); ?>

    <div class="col-lg-6">
        <?= $form->field($model, 'review')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'created')->textInput([
            'class' => 'cursor-disabled form-control',
            'readonly' => true,
        ]) ?>
        <?= $form->field($model, 'reviewer')->textInput([
            'class' => 'cursor-disabled form-control',
            'readonly' => true,
        ]) ?>

        <input type="hidden" name="type" value="<?= $role ?>">
        <input type="hidden" name="internEmail" value="<?= $internEmail ?>">
        <input type="hidden" name="id" value="<?= $model->id ?>">
        <input type="hidden" name="dateRange" value="<?= $dateRange ?>">

        <div class="form-group">
            <?php if ($thisUser->role != 'intern') { ?>
                <?= Html::submitButton('Submit', [
                    'class' => 'btn btn-primary',
                    'id' => 'btn-save-review'
                ]) ?>
            <?php } ?>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-supervisor-reviewsForm -->
