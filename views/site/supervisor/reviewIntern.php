<?php

/**
 * Project: Intern Portal.
 * User: nkmathew
 * Date: 13/09/2016
 * Time: 03:23
 */

/* @var $this yii\web\View */
/* @var $intern \app\models\User */

use app\assets\ReviewInternAsset;
ReviewInternAsset::register($this);

use \Carbon\Carbon;

$this->title = 'Review Intern';

$internName = $intern->profile->fullName();
$internEmail = $intern->email;

?>

<style>
    #logbook-list {
        width: 80%;
    }
    .modal-content {
        padding: 10px;
        height: 70% !important;
    }
    .modal-dialog{
        overflow: visible;
        height: 100% !important;
    }
</style>

<div class="site-reviewIntern container">
    <table data-intern-email="<?= $internEmail ?>" class="table-bordered table col-md-6" id="logbook-list">
        <caption>Progress for intern <em class="bitalics"><?= $internName ?></em> (<strong><?= $internEmail ?></strong>) </caption>
        <tr>
            <th>Week</th>
            <th>Week Start</th>
            <th>Week End</th>
            <th>Coordinator Review</th>
            <th>Supervisor Review</th>
        </tr>
        <?php
        for ($i = 0; $i < count($entries); $i++) {
            $entry = $entries[$i];
            $firstEntry = $entry[0];
            $firstDate = $firstEntry->entry_for;
            $first = $firstEntry->entry_for;
            $first = Carbon::parse($first)->format('l F jS, Y');
            $lastDate = $entry[count($entry) - 1]->entry_for;
            $last = $entry[count($entry) - 1]->entry_for;
            $last = Carbon::parse($last)->format('l F jS, Y');
            $weekNumber = $i + 1;
            $superReview = intval($firstEntry->supervisor_review);
            $coordReview = intval($firstEntry->coordinator_review);
            $superClass = 'btn-primary';
            $superLabel = 'View';
            $coordClass = 'btn-primary';
            $coordLabel = 'View';
            if (!$superReview) {
                $superClass = 'btn-warning';
                $superLabel = 'Add';
            }
            if (!$coordReview) {
                $coordClass = 'btn-warning';
                $coordLabel = 'Add';
            }
            echo <<<TABLE
          <tr>
            <td>Week $weekNumber</td>
            <td>$first</td>
            <td>$last</td>
            <td align="center">
               <button data-toggle="modal" data-target="#modal-reviewForm"
                       class="btn btn-sm $coordClass"
                        onClick="displayReview($coordReview, 'coord', '$firstDate|$lastDate')"
                       type="button">$coordLabel</button>
            </td>
            <td align="center">
               <button data-toggle="modal" data-target="#modal-reviewForm"
                        onClick="displayReview($superReview, 'superv', '$firstDate|$lastDate')"
                       class="btn btn-sm $superClass" type="button">
                 $superLabel
               </button>
               </td>
            <td align="center">
               <a class="btn btn-sm btn-primary" target="_blank"
                  href="/site/export-logbook?week=$weekNumber">Generate PDF</a>
            </td>
          </tr>
TABLE;
        }
        ?>
    </table>
</div>

<div id="modal-reviewForm" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body"></div>
        </div>
    </div>
</div>
