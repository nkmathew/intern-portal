<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use Carbon\Carbon;

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
    public $duration;
    public $startDate;

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
            [['duration'], 'integer'],
            // [['startDate'], 'safe'],
            [['startDate'], 'validateDateFormat'],
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
                    $year    = (int)date('Y');
                    $regYear = (int)explode('/', $this->regNumber)[1];
                    $diff    = ($regYear - $year);
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
     * Checks that the internship start date is not set to more than three months before or after now
     *
     * @param $date
     * @return bool
     */
    public function validateDateFormat($attribute, $params) {
        if (!$this->hasErrors()) {
            $profile = $this->getProfile();
            if ($profile) {
                $date = Carbon::createFromFormat('d/m/Y', $this->startDate);
                $monthDiff = $date->diffInMonths();
                $dateDiff = $date->diffForHumans();
                // throw new \Exception('Profile: ' . $profile);
                // $time = date('H:i:s');
                // throw new \Exception("Date[$time]: $profile->start_date ==> $this->startDate  <<$monthDiff>>");

                if ($monthDiff >= 3) {
                    $date = $date->format('l, jS F Y');
                    $this->addError($attribute, "Start date($date) is more than three months away($dateDiff)");
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

        $oldProfile          = clone $profile;
        $profile->email      = $this->email ? $this->email : '';
        $profile->sex        = $this->sex;
        $profile->surname    = $this->surname;
        $profile->firstname  = $this->firstName;
        $profile->reg_number = $this->regNumber;
        $profile->duration   = $this->duration;
        $profile->start_date = Carbon::createFromFormat('d/m/Y', $this->startDate)->format('Y-m-d');

        if ($oldProfile != $profile) {
            $profile->last_updated = time();
        }

        return $profile->update() ? $profile : null;
    }
}
