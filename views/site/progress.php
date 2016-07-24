<?php

/* @var $this yii\web\View */

$this->title = 'Progress tab';

use app\assets\ProgressAsset;

ProgressAsset::register($this);

?>

<div class="site-progress">
    <div id="internship-calendars" class="col-md-6">
        <div id="calendar-month-1" class="col-md-6 intern-calendar"></div>
        <div id="calendar-month-2" class="col-md-6 intern-calendar"></div>
        <div id="calendar-month-3" class="col-md-6 intern-calendar"></div>
        <div id="calendar-month-4" class="col-md-6 intern-calendar"></div>
    </div>
    <div class="col-md-6">
        <p>Stats corner</p>
    </div>
</div>
