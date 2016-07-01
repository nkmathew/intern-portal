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

    private $_profile;

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
            // Registration number is validated by validateRegNumber()
            ['regNumber', 'validateRegNumber'],
            // Trim spaces when submitting form
            [['firstName', 'regNumber', 'surname', 'email'], 'trim'],
        ];
    }

    /**
     * Finds profile by [[email]]
     *
     * @return Profile|null
     */
    protected function getProfile()
    {
        if ($this->_profile === null) {
            $this->_profile = Profile::findByEmail($this->email);
        }

        return $this->_profile;
    }

    /**
     * Validates the registration number.
     * This method serves as the inline validation for regNumber.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateRegNumber($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $profile = $this->getProfile();
            if ($profile) {
                $matchesCourse = $profile->validateRegNumber($this->regNumber);
                if (substr_count($this->regNumber, '/') != 1) {
                    $this->addError($attribute, 'A valid reg number has only one forward slash');
                } else {
                    $year = (int)date('Y');
                    $regYear = (int)explode('/', $this->regNumber)[1];
                    $diff = ($regYear - $year);
                    if (($diff > 0) || ($diff < -10)) {
                        $this->addError($attribute, 'Invalid year in registration number');
                    }
                }
                if (!$matchesCourse) {
                    $this->addError($attribute, 'No course matching that registration number');
                }
            } else {
                $this->addError($attribute, 'Could not find a profile associated with the email');
            }
        }
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
