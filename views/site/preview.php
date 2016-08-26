<?php

/**
 * @project: Intern Portal.
 * @author: nkmathew
 * @date: 01/08/2016
 * @time: 09:27
 */

/* @var $this yii\web\View */

use app\assets\PreviewAsset;

PreviewAsset::register($this);
?>

<div class="site-preview">
    <div id="entry-list" class="container" week="1">
        <script id="logbook-preview-template" type="text/x-handlebars-template">
            <div class="entry-body col-md-3 {{entry_class}}">
                <div class="entry-text {{entry_text_class}}">{{{entry}}}</div>
                <div class="date-overlay">{{entry_for}}</div>
            </div>
        </script>
    </div>
    <div class="nav-buttons">
        <button class="btn btn-sm btn-primary" onclick="prevWeek()">
            <span class="glyphicon glyphicon-step-backward"></span>Previous
        </button>
        <span class="btn btn-sm btn-success week-label" id="week-number">Week 8</span>
        <button class="btn btn-sm btn-primary" onclick="nextWeek()">Next
            <span class="glyphicon glyphicon-step-forward"></span>
        </button>
    </div>
</div>
