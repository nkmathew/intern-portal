<?php

namespace tests\codeception\_pages;

use yii\codeception\BasePage;
use app\models\SignupForm;

/**
 * Represents signup page
 * @property \AcceptanceTester|\FunctionalTester $actor
 */
class SignupPage extends BasePage
{

    public $route = 'site/signup';

    /**
     * @param array $signupData
     */
    public function submit(array $signupData)
    {
        $signupForm = new SignupForm;

        foreach ($signupData as $field => $value) {
            $inputType = $field === 'body' ? 'textarea' : 'input';
            $this->actor->fillField($inputType . '[name="' . $signupForm->formName() . '[' . $field . ']"]', $value);
        }
        $this->actor->click('signup-button');
    }
}
