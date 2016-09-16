<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \app\models\Config */
/* @var $form ActiveForm */

use app\assets\SupervisorConfigAsset;
SupervisorConfigAsset::register($this);

?>

<script>
</script>

<div class="site-supervisor-configForm">

    <?php $form = ActiveForm::begin([
        'action' => '/site/config-form',
        'id' => 'config-form',
        // 'validateOnSubmit' => true,
        // 'validateOnBlur' => true,
    ]); ?>

    <div class="col-lg-6">
        <label for="modify-later">Can entries be modified later?</label>
        <?= $form->field($model, 'can_modify_later', ['inputOptions' => [
            'enableLabel' => false,
        ]])->checkbox([
            'data-toggle' => 'toggle',
            'data-onstyle' => 'primary',
            'data-offstyle' => 'danger',
            'data-size' => 'small',
            'data-on' => 'Yes',
            'data-off' => 'No',
            'id' => 'modify-later'
        ]) ?>
        <label for="modify-later">Can intern make entry at a later date?</label>
        <?= $form->field($model, 'can_add_later')->checkbox([
            'data-toggle' => 'toggle',
            'data-onstyle' => 'primary',
            'data-offstyle' => 'danger',
            'data-size' => 'small',
            'data-on' => 'Yes',
            'data-off' => 'No',
            'id' => 'add-later'
        ]) ?>
        <?= $form->field($model, 'starting_hour')->textInput([
            'id' => 'starting-hour',
            'class' => 'form-control input-small',
        ]) ?>
        <?= $form->field($model, 'closing_hour')->textInput([
            'id' => 'closing-hour',
            'class' => 'form-control input-small'
        ]) ?>
        <?= $form->field($model, 'supervisor', ['options' => ['class' => 'hidden']])->textInput([
            'class' => 'cursor-disabled form-control',
            'readonly' => true,
            'value' => $email])
        ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-supervisor-configForm -->
