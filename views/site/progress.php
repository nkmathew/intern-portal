<?php

/* @var $this yii\web\View */

$this->title = 'Progress';

use app\assets\ProgressAsset;

ProgressAsset::register($this);

?>

<div class="site-progress">
    <div id="internship-calendars" class="col-md-6" data-startdate="<?= $startDate ?>" data-duration="<?= $duration ?>">
        <div id="calendar-month-1" class="col-md-6 intern-calendar"></div>
        <div id="calendar-month-2" class="col-md-6 intern-calendar"></div>
        <div id="calendar-month-3" class="col-md-6 intern-calendar"></div>
        <div id="calendar-month-4" class="col-md-6 intern-calendar"></div>
    </div>
    <div class="col-md-6">
        <div class="Mm">
            <div class="col-md-4 stat-container">
                <span class="stat-desc">Days Completed</span>
                <span class="stat-number"><?= $daysCompleted ?></span>
            </div>
            <div class="col-md-4 stat-container">
                <span class="stat-desc">Days Left</span>
                <span class="stat-number"><?= $daysLeft ?></span>
            </div>
            <div class="col-md-4 stat-container">
                <span class="stat-desc">Duration(Weeks)</span>
                <span class="stat-number"><?= $duration ?></span>
            </div>
            <div class="col-md-4 stat-container">
                <span class="stat-desc">Weeks Left</span>
                <span class="stat-number"><?= $weeksLeft ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <hr class="style9">
        <button class="btn-primary btn">Reveal Entries</button>
    </div>
</div>
