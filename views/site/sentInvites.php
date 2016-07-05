<?php

/**
 * @project: Intern Portal.
 * @author: nkmathew
 * @date: 03/07/2016
 * @time: 16:53
 */

/* @var $this yii\web\View */

use Carbon\Carbon;
use yii\bootstrap\Modal;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

$loggedInEmail = Yii::$app->user->identity->email;
$fullQuery = "select id,email,signup_token,date_sent,inviter, count(*) invite_count
              from signuplinks
              where inviter = '$loggedInEmail'
              group by email
              order by date_sent desc";
$countQuery = "select count(*)
               from signuplinks
               where inviter = '$loggedInEmail'
               group by email";

$dataProvider = new SqlDataProvider([
    'sql' => $fullQuery,
    'totalCount' => Yii::$app->db->createCommand($countQuery)->queryScalar(),
    'pagination' => false,
    'pagination' => [
        'pageSize' => 20,
    ],
]);

// Connect to modal
Modal::widget(['id' => "modal-token-list"]);

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
                $relativeTime = Carbon::createFromTimeStamp($model['date_sent'])->diffForHumans();

                return $relativeTime;
            },
        ],
        [
            'label' => 'Invite Count',
            'format' => 'raw',
            'contentOptions' => [
                'align' => 'center',
                'title' => 'Show all signup tokens generated for this student',
                'data-toggle' => 'modal',
                'data-target' => '#modal-token-list',
            ],
            'value' => function ($model) {
                $invites = $model['invite_count'];
                $email = $model['email'];
                return Html::button("<span class='badge'>$invites</span>",
                    [
                        'class' => 'btn btn-primary btn-xs',
                        'onClick' => "$('.modal-content').load('/site/list-invites-by-user?email=$email');",
                    ]);
            }
        ],
    ]
]);
?>

<style>
    .modal-content {
        padding: 4px;
        border-radius: 0px;
    }
</style>
<!-- Modal template -->
<div id="modal-token-list" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
