<?php

/**
 * @project: Intern Portal.
 * @author: nkmathew
 * @date: 22/06/2016
 * @time: 12:58
 */
use app\assets\LogbookAsset;

/* @var $this yii\web\View */

LogbookAsset::register($this);

?>

<div id="site-logbook">
    <div id="container-calendar" class="col-md-6">
        <div id="container-logbook-date"></div>
    </div>
    <div class="col-md-6">
        <script id="logbook-template" type="text/x-handlebars-template">
            <div id="entry-stats" class="well well-sm">
                <div class="entry-date-updated">
                    <span class="glyphicon glyphicon-time"></span>
                    Changed: {{updated}}
                </div>
                <div class="entry-date-created">
                    <span class="glyphicon glyphicon-dashboard"></span>
                    Created: &nbsp; {{created}}
                </div>
                <div class="entry-date-created">
                    <span class="glyphicon glyphicon-calendar"></span>
                    Entry for: &nbsp; {{entry_for}}
                </div>
            </div>
            <div class="form-group field-logbook-text">
            <textarea id="logbook-text"
                      class="form-control"
                      rows="10"
                      placeholder="What did you do today?">{{entry}}</textarea>
                <p class="help-block help-block-error"></p>
            </div>
            <div class="form-group">
                <button type="submit" id="btn-save-logbook" class="btn btn-primary" name="login-button">
                    <span class="glyphicon glyphicon-floppy-disk"></span> Save
                </button>
            </div>
        </script>
        <div id="container-logbook"></div>
    </div>
</div>
