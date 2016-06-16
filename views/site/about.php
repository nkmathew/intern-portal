<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>JKUAT Intern Management System</p>
    <p>A system that automates the internship process essentially doing away with the need for a logbook for keeping track of progress enabling a supervisor and coordinator to monitor student progress easily.</p>
    <hr />
    <h3 id="todofeatures">TODO/Features</h3>
    <ul>
        <li>Design simple logo</li>
        <li>Should support login for three types of users:</li>
        <li>Coordinators
            <ul>
                <li>The teacher/lecturer in who does supervision of all the interns from a certain class and does an on site assessment of the student interns in their placements</li>
            </ul>
        </li>
        <li>Supervisors
            <ul>
                <li>The person who monitors student progress in his/her place of work</li>
            </ul>
        </li>
        <li>Intern
            <ul>
                <li>The student doing the industrial attachment</li>
            </ul>
        </li>
        <li>Coordinator:</li>
        <li>Has to key in list of students on internship</li>
        <li>Support import from csv file, created by the class rep maybe</li>
        <li>Should be able to see the progress of all the students in the class doing the internship</li>
        <li>System has an option for sending mass emails to all the students with links that enable them to signup to the system and changing their loggin details</li>
        <li>Supervisor</li>
        <li>Has access to progress data of all the interns under his/her supervision</li>
        <li>Should allow option for defining whether the intern does work on weekends</li>
        <li>Decides the number of weeks the intern is supposed to be on internship. The minimum should be at least 8 weeks required by all institutions</li>
        <li>Fills details on the industry/office/firm the intern works in including:
            <ul>
                <li>The physical location of the firm</li>
                <li>The department</li>
                <li>The room name/number each of the interns under his supervision will work in</li>
                <li>General description of the workplace and what they do</li>
                <li>Working hours(start and departure date)</li>
                <li>Give's weekly report on the progress of the intern</li>
            </ul>
        </li>
        <li>Should have a form that enables the supervisor to note down the students progress during the internship</li>
        <li>Intern</li>
        <li>Fills logbook daily</li>
        <li>Should show the intern his/her progess including:
            <ul>
                <li>The number of days he's done</li>
                <li>The number of hours completed in general taking into account the working hours defined by the supervisor</li>
                <li>The number of days left to complete the 8/12 weeks set</li>
            </ul>
        </li>
        <li>Signs up in the system only on invite from the email sent by the coordinator to the school email address.</li>
        <li>System should support reset of lost passwords</li>
        <li>Show a calendar showing the number of days completed and days left</li>
    </ul>
</div>
