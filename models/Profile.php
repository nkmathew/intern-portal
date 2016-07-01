<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property integer $id
 * @property string $sex
 * @property string $email
 * @property string $firstname
 * @property string $surname
 * @property string $reg_number
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'email', 'firstname', 'surname'], 'string', 'max' => 255],
            [['reg_number'], 'string', 'max' => 20],
            [['email'], 'unique'],
            [['email'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['email' => 'email']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sex' => 'Sex',
            'email' => 'Email',
            'firstname' => 'Firstname',
            'surname' => 'Surname',
            'reg_number' => 'Reg Number',
        ];
    }
    
    /**
     * Finds profile by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }


    /**
     * Validates regNumber
     *
     * @param string $regNumber Registration number to validate
     * @return boolean if reg number provided is valid
     */
    public function validateRegNumber($regNumber)
    {
        $regNumber = explode('-', $regNumber)[0];
        return Course::findBySql("SELECT * FROM courses WHERE course_code LIKE '$regNumber%' LIMIT 10")->one();
    }
}
