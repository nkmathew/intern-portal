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

?>

<div class="site-profile">
    <div class="row">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin([
                'action' => '/site/profile',
                'id' => 'profile-form',
                'validateOnSubmit' => true,
                'validateOnBlur' => true,
            ]); ?>
            <div class="panel panel-default">
                <div class="panel-heading">Personal Details</div>
                <div class="panel-body">
                    <?= $form->field($model, 'firstName')->textInput(['autofocus' => true, 'value' => $model->firstName]) ?>
                    <?= $form->field($model, 'surname')->textInput(['value' => $model->surname]) ?>
                    <?= $form->field($model, 'regNumber', ['enableAjaxValidation' => true])->textInput(['value' => $model->regNumber]) ?>
                    <?= $form->field($model, 'email')->textInput([
                        'class' => 'cursor-disabled form-control',
                        'readonly' => true,
                        'value' => $model->email])
                    ?>
                    <?= $form->field($model, 'sex')->dropDownList(['Male', 'Female', 'Other']); ?>
                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'id' => 'btn-submit-profile']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
