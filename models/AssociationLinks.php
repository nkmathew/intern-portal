<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "associationlinks".
 *
 * @property integer $id
 * @property string $intern
 * @property string $token
 * @property string $date_sent
 * @property string $supervisor
 * @property integer $is_disabled
 *
 * @property User $intern0
 * @property User $supervisor0
 */
class AssociationLinks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'associationlinks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intern', 'token', 'date_sent', 'supervisor'], 'required'],
            [['date_sent'], 'safe'],
            [['is_disabled'], 'integer'],
            [['intern', 'token', 'supervisor'], 'string', 'max' => 255],
            [['token'], 'unique'],
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
            'token' => 'Token',
            'date_sent' => 'Date Sent',
            'supervisor' => 'Supervisor',
            'is_disabled' => 'Is Disabled',
        ];
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

    /**
     * Generates a token
     */
    public function generateToken()
    {
        $this->token = Yii::$app->security->generateRandomString() . '_' . time();
    }
}
