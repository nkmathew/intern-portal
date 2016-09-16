<?php

/**
 * Project: Intern Portal.
 * User: nkmathew
 * Date: 06/09/2016
 * Time: 15:41
 */
use Carbon\Carbon;

/* @var $this yii\web\View */

$this->title = 'Overview';

?>

<style>
    .hr-style {
        border-color: black;
        margin-top: 18px;
        margin-bottom: 25px;
    }
    .table-header {
        text-align:center;
        font-weight:bold;
        background-color:gray;
        color:white;
    }
</style>

<div class="site-overview">
    <caption>Week <?= $weekNumber ?></caption>
    <table border="1" cellpadding="10">
        <col width="150px">
        <tr>
            <th class="table-header" colspan="2">Date</th>
            <th class="table-header" colspan="9">Entry</th>
        </tr>
        <?php
        foreach ($entryList as $x => $entry) {
            $x++;
            $date = $entry['entry_for'];
            $date = Carbon::parse($date)->format('l|F jS, Y');
            $date = explode('|', $date);
            echo <<<EOD
    <tr>
        <td colspan="2"><strong>Day $x ($date[0])</strong><br><br>$date[1]</td>
        <td colspan="9">$entry[entry]</td>
    </tr>
EOD;
        }
        ?>
    </table>
    <br>
    <br>
    <br>
    <br>
    <?php
    $first = $entryList[0];
    echo "<strong>Coordinator's Review:</strong>";
    if ($first->coordinatorReview) {
        $review = $first->coordinatorReview->review;
        echo "<p>$review</p>";
    }
    echo "<br>";
    echo "<strong>Supervisor's Review:</strong>";
    if ($first->supervisorReview) {
        $review = $first->supervisorReview->review;
        echo "<p>$review</p>";
    }
    ?>
</div>
