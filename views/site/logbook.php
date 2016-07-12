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

$_SESSION['nombre'] = 'Juan';

?>

<div id="site-logbook">
    <div id="container-calendar" class="col-md-6">
        <div id="container-logbook-date"></div>
    </div>
    <div class="col-md-6">
        <div class="form-group field-logbook-text">
            <label class="control-label" for="logbook-text"></label>
            <textarea id="logbook-text"
                      class="form-control"
                      rows="10"
                      placeholder="What did you do today?"></textarea>
            <p class="help-block help-block-error"></p>
        </div>
        <div class="form-group">
            <button type="submit" id="btn-save-logbook" class="btn btn-primary" name="login-button">
                <span class="glyphicon glyphicon-floppy-disk"></span> Save
            </button>
        </div>
    </div>
</div>
