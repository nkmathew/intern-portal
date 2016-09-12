<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "associations".
 *
 * @property integer $id
 * @property string $intern
 * @property string $supervisor
 * @property string $coordinator
 *
 * @property User $coordinator0
 * @property User $intern0
 * @property User $supervisor0
 */
class Associations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'associations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intern', 'supervisor', 'coordinator'], 'string', 'max' => 255],
            [['coordinator'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['coordinator' => 'email']],
            [['intern'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['intern' => 'email']],
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
            'intern' => 'Intern',
            'supervisor' => 'Supervisor',
            'coordinator' => 'Coordinator',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoordinator0()
    {
        return $this->hasOne(User::className(), ['email' => 'coordinator']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIntern0()
    {
        return $this->hasOne(User::className(), ['email' => 'intern']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupervisor0()
    {
        return $this->hasOne(User::className(), ['email' => 'supervisor']);
    }
}
