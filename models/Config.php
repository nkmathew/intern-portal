<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property integer $id
 * @property string $supervisor
 * @property integer $can_modify_later
 * @property integer $can_add_later
 * @property string $starting_hour
 * @property string $closing_hour
 *
 * @property User $supervisor0
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supervisor'], 'required'],
            [['can_modify_later', 'can_add_later'], 'integer'],
            [['starting_hour', 'closing_hour'], 'safe'],
            [['supervisor'], 'string', 'max' => 255],
            [['supervisor'], 'unique'],
            [['supervisor'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['supervisor' => 'email']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supervisor' => 'Supervisor',
            'can_modify_later' => '',
            'can_add_later' => '',
            'starting_hour' => 'Starting Hour',
            'closing_hour' => 'Closing Hour',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupervisor0()
    {
        return $this->hasOne(User::className(), ['email' => 'supervisor']);
    }
}
