<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "logbook".
 *
 * @property integer $id
 * @property string $entry
 * @property string $updated
 * @property string $created
 * @property string $author
 * @property string $entry_for
 * @property integer $supervisor_review
 * @property integer $coordinator_review
 *
 * @property CoordinatorReviews $coordinatorReview
 * @property User $author0
 * @property SupervisorReviews $supervisorReview
 */
class Logbook extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'logbook';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entry'], 'string'],
            [['updated', 'created', 'supervisor_review', 'coordinator_review'], 'integer'],
            [['author', 'entry_for'], 'required'],
            [['entry_for'], 'safe'],
            [['author'], 'string', 'max' => 255],
            [['coordinator_review'], 'exist', 'skipOnError' => true, 'targetClass' => CoordinatorReviews::className(), 'targetAttribute' => ['coordinator_review' => 'id']],
            [['author'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author' => 'email']],
            [['supervisor_review'], 'exist', 'skipOnError' => true, 'targetClass' => SupervisorReviews::className(), 'targetAttribute' => ['supervisor_review' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entry' => 'Entry',
            'updated' => 'Updated',
            'created' => 'Created',
            'author' => 'Author',
            'entry_for' => 'Entry For',
            'supervisor_review' => 'Supervisor Review',
            'coordinator_review' => 'Coordinator Review',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoordinatorReview()
    {
        return $this->hasOne(CoordinatorReviews::className(), ['id' => 'coordinator_review']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor0()
    {
        return $this->hasOne(User::className(), ['email' => 'author']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupervisorReview()
    {
        return $this->hasOne(SupervisorReviews::className(), ['id' => 'supervisor_review']);
    }
}
