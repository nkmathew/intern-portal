<?php

/* @var $this yii\web\View */

$this->title = 'Progress tab';

use app\assets\ProgressAsset;

ProgressAsset::register($this);

?>

<div class="site-progress">
    <div class="col-md-9">
        <div id="calendar-month-1" class="col-md-4"></div>
        <div id="calendar-month-2" class="col-md-4"></div>
        <div id="calendar-month-3" class="col-md-4"></div>
    </div>
</div>
