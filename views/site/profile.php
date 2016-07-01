<?php

/**
 * @project: Intern Portal.
 * @author: nkmathew
 * @date: 20/06/2016
 * @time: 17:09
 */

/* @var $this yii\web\View */
/* @var $model app\models\Profile */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="site-profile">
    <p>
        Update your profile below
    </p>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                'action' => '/site/profile',
                'id' => 'profile-form',
                'validateOnSubmit' => true,
                'validateOnBlur' => true,
            ]); ?>
            <?= $form->field($model, 'firstName')->textInput(['autofocus' => true, 'value' => $model->firstName]) ?>
            <?= $form->field($model, 'surname')->textInput(['value' => $model->surname]) ?>
            <?= $form->field($model, 'regNumber', ['enableAjaxValidation' => true])->textInput(['value' => $model->regNumber]) ?>
            <?= $form->field($model, 'email')->textInput(['readonly' => true, 'value' => $model->email]) ?>
            <?= $form->field($model, 'sex')->dropDownList(['Male', 'Female', 'Other']); ?>
            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'id' => 'btn-submit-profile']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
