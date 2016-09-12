<?php

use app\models\SupervisorProfile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SupervisorProfile */
/* @var $form ActiveForm */

use app\assets\SupervisorProfileAsset;

SupervisorProfileAsset::register($this);

$this->title = "Supervisor's Profile";
?>


<div class="site-supervisorProfile">

    <?php $form = ActiveForm::begin([
        'action' => '/site/supervisor-profile',
        'id' => 'supervisorprofile-form',
        'validateOnSubmit' => true,
        'enableAjaxValidation' => true
    ]); ?>

    <div class="col-lg-5">
        <?= $form->field($model, 'firstname')->textInput(['value' => $model->firstname]) ?>
        <?= $form->field($model, 'surname')->textInput(['value' => $model->surname]) ?>
        <?= $form->field($model, 'id_number')->textInput(['value' => $model->id_number]) ?>
        <?= $form->field($model, 'company_name')->textInput(['value' => $model->company_name]) ?>
        <?= $form->field($model, 'company_address')->textInput(['value' => $model->company_address]) ?>
        <?= $form->field($model, 'work_position')->textInput(['value' => $model->work_position]) ?>
        <?= $form->field($model, 'phone_number')->textInput(['value' => $model->phone_number]) ?>
        <?= $form->field($model, 'sex')->dropDownList([
            'male' => 'Male',
            'female' => 'Female',
            'other' => 'Other'
        ]); ?>
        <?= $form->field($model, 'email', ['options' => ['class' => 'hidden']])->textInput([
            'class' => 'cursor-disabled form-control',
            'readonly' => true,
            'value' => $model->email])
        ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'id' => 'btn-submit-profile']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
