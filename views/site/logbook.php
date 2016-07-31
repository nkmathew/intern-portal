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
        <div id="new-entry-prompt" class="alert alert-danger hidden centered-text col-md-12">
            No entry found for <strong id="selected-date"></strong>, click to create one.<br/>
            <button id="btn-create-new-entry" class="btn btn-sm btn-primary" onclick="prepareForNewEntry()">
                <span class="glyphicon glyphicon-plus"></span>
                New Entry
            </button>
        </div>
        <script id="logbook-template" type="text/x-handlebars-template">
            <div id="logbook-entry-area" data-entry-for="{{entry_for}}" data-updated="{{updated}}" data-created="{{created}}">
                <div class="entry-stats well well-sm">
                    <div class="stat entry-date-updated" title="Edited" data-placement="left" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-time"></span>
                        <span id="entry-updated">{{updated1}}</span>
                    </div>
                    <div class="stat entry-date-created" title="Created" data-placement="left" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-dashboard"></span>
                        <span id="entry-created">{{updated1}}</span>
                    </div>
                    <div class="stat entry-date-created" title="Entry For" data-placement="left" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-calendar"></span>
                        {{entryDate}}
                    </div>
                </div>
                <div class="form-group field-logbook-text">
                    <textarea id="logbook-editor"
                              name="logbook-editor"
                              class="form-control"
                              rows="10"
                              placeholder="What did you do today?">{{entry}}</textarea>
                    <p class="help-block help-block-error"></p>
                </div>
                <div class="form-group">
                    <button id="btn-save-logbook" class="btn btn-sm btn-primary" onclick="saveLogbookEntry()">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        <span id="btn-save-logbook-label">
                            Save
                        </span>
                    </button>
                    <button id="btn-delete-logbook" class="btn btn-sm btn-danger" onclick="">
                        <span class="glyphicon glyphicon-floppy-remove"></span>
                        Delete
                    </button>
                </div>
            </div>
        </script>
        <div id="container-logbook"></div>
    </div>
</div>
