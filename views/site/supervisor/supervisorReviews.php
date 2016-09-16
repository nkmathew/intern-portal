<?php

/**
 * Project: Intern Portal.
 * User: nkmathew
 * Date: 11/09/2016
 * Time: 15:57
 */

/* @var $this yii\web\View */

$this->title = 'Supervisor Reviews';

?>

<div class="site-supervisorReviews">
    <div class="col-xs-2"> <!-- required for floating -->
        <!-- Nav tabs -->
        <ul class="nav nav-tabs tabs-left">
            <li class="active"><a href="#tab-associateIntern" data-toggle="tab">Add Intern</a></li>
            <li><a href="#tab-intern-overview" data-toggle="tab">Intern Overview</a></li>
        </ul>
    </div>
    <div class="col-xs-9">
        <div class="tab-content">
            <div class="tab-pane active" id="tab-associateIntern">
                <?= $this->render('internList'); ?>
                <hr class="style4">
                <?= $this->render('associateWithIntern'); ?>
            </div>
            <div class="tab-pane" id="tab-intern-overview">
                <p>this is funny</p>
            </div>
        </div>
    </div>
</div>
