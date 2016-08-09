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
    <div id="entry-list" class="container">
        <script id="logbook-preview-template" type="text/x-handlebars-template">
            <div class="entry-body col-md-3">
                <div class="entry-text">{{{entry}}}</div>
                <div class="date-overlay">{{entry_for}}</div>
            </div>
        </script>
    </div>
    <div class="nav-buttons">
        <button class="btn btn-primary">Refresh</button>
        <button class="btn btn-primary">Next</button>
    </div>
</div>
