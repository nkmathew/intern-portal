<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property integer $id
 * @property string $reviewer
 * @property string $review
 * @property string $reviewed_intern
 * @property string $created
 *
 * @property Logbook[] $logbooks
 * @property Logbook[] $logbooks0
 * @property User $reviewedIntern
 * @property User $reviewer0
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['review'], 'string'],
            [['created'], 'safe'],
            [['reviewer', 'reviewed_intern'], 'string', 'max' => 255],
            [['reviewed_intern'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['reviewed_intern' => 'email']],
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
            'reviewed_intern' => 'Reviewed Intern',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogbooks()
    {
        return $this->hasMany(Logbook::className(), ['coordinator_review' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogbooks0()
    {
        return $this->hasMany(Logbook::className(), ['supervisor_review' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewedIntern()
    {
        return $this->hasOne(User::className(), ['email' => 'reviewed_intern']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewer0()
    {
        return $this->hasOne(User::className(), ['email' => 'reviewer']);
    }
}
