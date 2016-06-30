<?php

/**
 * @project: Intern Portal.
 * @author: nkmathew
 * @date: 23/06/2016
 * @time: 15:43
 */

/* @var $this yii\web\View */

?>

<div class="site-coordinator-console">
    <div class="col-md-5">
        <div class="input-group">
            <div id="btn-add-email"
                 title="Add email to list"
                 data-toggle="tooltip"
                 class="input-group-addon glyphicon glyphicon-plus"></div>
            <input type="text" id="email-input-box" class="form-control" placeholder="First part of student email">
            <span class="input-group-addon" id="basic-addon2">@students.jkuat.ac.ke</span>
        </div>
        <div class="well well-sm" id="email-list-section">
            <script id="email-list-template" type="text/x-handlebars-template">
                <div class="email-line">
                    <div class="email-address btn-xs btn-primary">
                        <a href="mailto:{{email}}">{{email}}</a>
                    </div>
                    <button type="button" class="email-delete-btn btn btn-danger btn-xs">
                        <span class="glyphicon glyphicon-remove-circle"></span>
                    </button>
                </div>
            </script>
        </div>
        <button type="button" id="invite-button" class="btn btn-primary">
            <span class="glyphicon glyphicon-send"></span> Send invite links
        </button>
    </div>
</div>
