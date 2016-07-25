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
        <p>Test</p>
    </div>
    <div class="col-md-6">
        <div class="Mm">
            <div class="stat-container">
                <span class="stat-number"><?= abs($daysLeft) ?></span>
                <span class="stat-desc">days left
                    <?php
                    if ($daysLeft < 0) {
                        echo 'till start of Internship';
                    }
                    ?>
                </span>
            </div>
        </div>
    </div>
</div>
