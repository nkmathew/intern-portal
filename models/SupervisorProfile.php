<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supervisorprofile".
 *
 * @property integer $id
 * @property string $sex
 * @property string $email
 * @property string $firstname
 * @property string $surname
 * @property string $id_number
 * @property string $company_name
 * @property string $company_address
 * @property string $work_position
 * @property string $phone_number
 * @property string $last_updated
 *
 * @property User $email0
 */
class SupervisorProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'supervisorprofile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['last_updated'], 'safe'],
            [['sex', 'email', 'firstname', 'surname', 'id_number', 'company_name', 'company_address', 'work_position', 'phone_number'], 'string', 'max' => 255],
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
            'id_number' => 'Id Number',
            'company_name' => 'Company Name',
            'company_address' => 'Company Address',
            'work_position' => 'Work Position',
            'phone_number' => 'Phone Number',
            'last_updated' => 'Last Updated',
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
     * Returns's full name
     */
    public function fullName() {
        return "$this->firstname $this->surname";
    }

}
