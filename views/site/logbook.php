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
        <div id="new-entry-prompt" class="hidden centered-text col-md-12 well">
            <button id="btn-create-new-entry" class="btn btn-primary" onclick="promptForNewEntry()">Create New Entry</button>
        </div>
        <script id="logbook-template" type="text/x-handlebars-template">
            <div id="logbook-entry-area">
                <div class="entry-stats well well-sm">
                    <div class="stat entry-date-updated" title="Edited" data-placement="left" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-time"></span>
                        {{updated}}
                    </div>
                    <div class="stat entry-date-created" title="Created" data-placement="left" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-dashboard"></span>
                        {{created}}
                    </div>
                    <div class="stat entry-date-created" title="Entry For" data-placement="left" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-calendar"></span>
                        {{entry_for}}
                    </div>
                </div>
                <div class="form-group field-logbook-text">
                    <textarea id="logbook-text" class="form-control" rows="10" placeholder="What did you do today?">{{entry}}</textarea>
                    <p class="help-block help-block-error"></p>
                </div>
                <div class="form-group">
                    <button type="submit" id="btn-save-logbook" class="btn btn-primary" onclick="saveLogbookEntry()">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        <span id="btn-save-logbook-label">
                            Save
                        </span>
                    </button>
                </div>
            </div>
        </script>
        <div id="container-logbook"></div>
    </div>
</div>
