<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>

<style>
    .alert {
        font-weight: bold;
    }
</style>
<div class="site-error">
    <h3><?= Html::encode($this->title) ?></h3>
    <div class="alert alert-danger">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <?= nl2br(Html::encode($message)) ?>
    </div>
    <p>Please contact us if you think this is a server error. Thank you</p>
</div>
