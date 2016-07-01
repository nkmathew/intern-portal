<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ProfileForm extends Model
{
    public $name;
    public $firstName;
    public $regNumber;
    public $surname;
    public $sex;
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['firstName', 'surname', 'sex', 'email', 'regNumber'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
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

        $profile = Profile::findByEmail($this->email);
        $profile->email = $this->email ? $this->email : '';
        $profile->sex = $this->sex;
        $profile->surname = $this->surname;
        $profile->firstname = $this->firstName;
        $profile->reg_number = $this->regNumber;

        return $profile->update() ? $profile : null;
    }
}
