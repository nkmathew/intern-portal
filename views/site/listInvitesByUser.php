<?php

/**
 * @project: Intern Portal.
 * @author: nkmathew
 * @date: 03/07/2016
 * @time: 16:53
 */

/* @var $this yii\web\View */

use app\models\SignupLinks;
use Carbon\Carbon;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\Modal;

$dataProvider = new ActiveDataProvider([
    'query' => SignupLinks::find()->where(['email' => $email]),
    'pagination' => [
        'pageSize' => 20,
    ],
]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'label' => 'ID',
            'attribute' => 'id'
        ],
        [
            'label' => 'Intern Email',
            'attribute' => 'email'
        ],
        [
            'label' => 'Signup Token',
            'attribute' => 'signup_token'
        ],
        [
            'label' => 'Sent',
            'attribute' => 'date_sent',
            'value' => function ($model) {
                $relativeTime = Carbon::createFromTimeStamp($model->date_sent)->diffForHumans();

                return $relativeTime;
            },
        ],
    ]
]);
?>

