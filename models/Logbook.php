<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "logbook".
 *
 * @property integer $id
 * @property string $entry
 * @property integer $updated
 * @property integer $created
 * @property string $author
 * @property string $entry_for
 *
 * @property User $author0
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
            [['updated', 'created'], 'integer'],
            [['entry_for'], 'required'],
            [['entry_for'], 'safe'],
            [['entry', 'author'], 'string', 'max' => 255],
            [['entry_for'], 'unique'],
            [['author'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author' => 'email']],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor0()
    {
        return $this->hasOne(User::className(), ['email' => 'author']);
    }

    /**
     * Returns a logbook entry for a certain date
     *
     * @param $date A string date
     */
    public function getEntryByDate($date)
    {
        $this::findOne(['entry_for' => $date]);
    }
}
