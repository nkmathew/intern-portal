<?php

/**
 * @project: Intern Portal.
 * @author: nkmathew
 * @date: 24/06/2016
 * @time: 09:02
 */
 
/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Link Signup';
?>

<div class="site-link-signup">
    <h3>Student intern link signup</h3>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup', 'action' => '/site/signup']); ?>
            <?= $form->field($model, 'email')->textInput(['readonly' => true, 'value' => $email]) ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <input type="hidden" name="signup_token" value="<?= $signup_token ?>">
            <div class="form-group">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
