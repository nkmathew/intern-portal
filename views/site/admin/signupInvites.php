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
    <div class="col-md-7">
        <div class="input-group">
            <input type="text" id="email-input-box" class="form-control" placeholder="Supervisor Email...">
            <span class="input-group-btn">
                <button id="btn-add-email" class="btn btn-primary">Add to list</button>
            </span>
        </div>
        <div class="well well-sm" id="email-list-section">
            <script id="email-list-template" type="text/x-handlebars-template">
                <div class="email-line">
                    <div class="email-address btn-xs btn-primary">
                        <a href="mailto:{{email}}">{{email}}</a>
                    </div>
                    <button type="button" class="email-delete-btn btn btn-danger btn-xs">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </div>
            </script>
        </div>
        <button type="button" id="btn-invite-sender" class="btn btn-primary">
            <span class="glyph-sm glyphicon glyphicon-send"></span> Send invite links
        </button>
    </div>
</div>
