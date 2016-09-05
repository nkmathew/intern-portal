<?php
namespace app\models;

use yii\base\Model;

/**
 * Supervisor profile form
 */
class SupervisorProfileForm extends Model
{
    public $id;
    public $sex;
    public $firstname;
    public $email;
    public $surname;
    public $id_number;
    public $company_name;
    public $company_address;
    public $work_position;
    public $phone_number;
    public $last_updated;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                [
                    'sex', 'email', 'firstname',
                    'surname', 'id_number', 'company_name',
                    'company_address', 'work_position', 'phone_number',
                ], 'required'],
        ];
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
