<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "coordinator_reviews".
 *
 * @property integer $id
 * @property string $reviewer
 * @property string $review
 * @property string $created
 *
 * @property User $reviewer0
 * @property Logbook[] $logbooks
 */
class CoordinatorReviews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coordinator_reviews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['review'], 'string'],
            [['created'], 'safe'],
            [['reviewer'], 'string', 'max' => 255],
            [['reviewer'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['reviewer' => 'email']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reviewer' => 'Reviewer',
            'review' => 'Review',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewer0()
    {
        return $this->hasOne(User::className(), ['email' => 'reviewer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogbooks()
    {
        return $this->hasMany(Logbook::className(), ['coordinator_review' => 'id']);
    }
}
