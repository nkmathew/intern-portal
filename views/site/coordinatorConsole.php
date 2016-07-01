<?php

/* @var $this yii\web\View */

?>

<title>Home</title> <!-- For Pjax's sake -->
<div class="site-coordinator-console">
    <div class="col-xs-2"> <!-- required for floating -->
        <!-- Nav tabs -->
        <ul class="nav nav-tabs tabs-left">
            <li class="active"><a href="#home" data-toggle="tab">Send Signup invites</a></li>
            <li><a href="#profile" data-toggle="tab">Signup Invite List</a></li>
        </ul>
    </div>
    <div class="col-xs-9">
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="home">
                <?= $this->render('signupInvites'); ?>
            </div>
            <div class="tab-pane" id="profile">Profile Tab.</div>
        </div>
    </div>
</div>
