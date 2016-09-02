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
 * @property string $role
 * @property string $last_updated
 *
 * @property User $email0
 * @property UserRoles $role0
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
            [['sex', 'email', 'firstname', 'surname', 'id_number', 'company_name', 'company_address', 'work_position', 'phone_number', 'role'], 'string', 'max' => 255],
            // [['email'], 'unique'],
            // [['email'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['email' => 'email']],
            [['role'], 'exist', 'skipOnError' => true, 'targetClass' => UserRoles::className(), 'targetAttribute' => ['role' => 'role_name']],
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
            'role' => 'Role',
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
     * Updates profile
     *
     * @return User|null the saved model or null if saving fails
     */
    public function updateProfile()
    {
        if (!$this->validate()) {
            return null;
        }

        $profile = SupervisorProfile::findByEmail($this->email);

        $oldProfile = clone $profile;
        $profile->email = $this->email ? $this->email : '';
        $profile->sex = $this->sex;
        $profile->surname = $this->surname;
        $profile->firstname = $this->firstname;
        $profile->id_number = $this->id_number;
        $profile->company_name = $this->company_name;
        $profile->company_address = $this->company_address;
        $profile->work_position = $this->work_position;
        $profile->phone_number = $this->phone_number;

        if ($oldProfile != $profile) {
            $profile->last_updated = date('Y-m-d H:i:s');
        }

        return $profile->update() ? $profile : null;
    }
}
