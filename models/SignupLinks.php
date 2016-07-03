<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "signuplinks".
 *
 * @property integer $id
 * @property string $email
 * @property integer $date_sent
 * @property string $inviter
 * @property string $signup_token
 * @property string $token_disabled
 */
class SignupLinks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'signuplinks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email', 'signup_token'], 'string', 'max' => 255],
            [['signup_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'signup_token' => 'Signup Token',
        ];
    }

    /**
     * Finds signup token by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Generates a signup token
     */
    public function generateSignupToken()
    {
        $this->signup_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

}
