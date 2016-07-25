<?php

/**
 * @project: Intern Portal.
 * @author: nkmathew
 * @date: 20/06/2016
 * @time: 17:09
 */

/* @var $this yii\web\View */
/* @var $model app\models\Profile */

use app\assets\ProfileAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

ProfileAsset::register($this);

$this->title = "Profile";

?>

<div class="site-profile">
    <div class="row">
        <?php $form = ActiveForm::begin([
            'action' => '/site/profile',
            'id' => 'profile-form',
            'validateOnSubmit' => true,
            'validateOnBlur' => true,
        ]); ?>
        <div style="overflow:auto;clear:both">
            <div class="col-lg-6">
                <div class="panel panel-primary panel-default">
                    <div class="panel-heading">Personal Details</div>
                    <div class="panel-body">
                        <?= $form->field($model, 'firstName')->textInput(['value' => $model->firstName]) ?>
                        <?= $form->field($model, 'surname')->textInput(['value' => $model->surname]) ?>
                        <?= $form->field($model, 'regNumber', ['enableAjaxValidation' => true])->textInput(['value' => $model->regNumber]) ?>
                        <?= $form->field($model, 'email', ['options' => ['class' => 'hidden']])->textInput([
                            'class' => 'cursor-disabled form-control',
                            'readonly' => true,
                            'value' => $model->email])
                        ?>
                        <?= $form->field($model, 'sex')->dropDownList(['Male', 'Female', 'Other']); ?>
                    </div>
                </div>
            </div>
            <div class="container-placement col-lg-6">
                <div class="panel panel-primary panel-default">
                    <div class="panel-heading">Placement Information</div>
                    <div class="panel-body">
                        <div id="test-div"></div>
                        <?= $form->field($model, 'duration')->dropDownList([
                            8 => '8 Weeks',
                            12 => '12 Weeks'
                        ]); ?>
                        <?= $form->field($model, 'startDate', ['enableAjaxValidation' => true])->textInput([
                            'value' => date_format(date_create($model->startDate), 'm/d/Y')
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="" style="padding-left:50%;padding-right:50%">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'id' => 'btn-submit-profile']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
