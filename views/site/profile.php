<?php

/**
 * @project: Intern Portal.
 * @author: nkmathew
 * @date: 20/06/2016
 * @time: 17:09
 */
 
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'First profile tab';
?>

<div>
    <?= Html::a('Pjax Link tester', ['update', 'id' => '#s'], ['data-pjax'=> '#formsection']) ?>
    <p>This is some cool stuff
    </p>
</div>