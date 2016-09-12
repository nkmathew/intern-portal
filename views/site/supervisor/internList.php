<?php

/* @var $this yii\web\View */

use app\models\User;

$user = User::findByEmail(Yii::$app->user->identity->email);
$associations = $user->associations1;
if (count($associations) == 0) {
    $associations = $user->associations;
}

?>

<style>
    #intern-list th {
        padding: 4px
    }
</style>

<table class="table table-striped table-bordered" id="intern-list">
    <caption>Interns under your supervision:</caption>
    <tr>
        <th>Name</th>
        <th>Registration Number</th>
        <th>Email</th>
        <th>Sex</th>
    </tr>
    <?php
    foreach ($associations as $assoc) {
        $profile = $assoc->intern0->profile;
        $name = $profile->fullName();
        $regNumber = $profile->reg_number;
        $email = $profile->email;
        $sex = [0 => 'Male', 1 => 'Female'][$profile->sex];
        echo "
          <tr>
            <td>$name</td>
            <td>$regNumber</td>
            <td>$email</td>
            <td>$sex</td>
          </tr>
        ";
    }
    ?>
</table>
