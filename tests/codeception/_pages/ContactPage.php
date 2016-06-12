<?php

namespace tests\codeception\_pages;

use yii\codeception\BasePage;
use app\models\ContactForm;

/**
 * Represents contact page
 * @property \AcceptanceTester|\FunctionalTester $actor
 */
class ContactPage extends BasePage
{
    public $route = 'site/contact';

    /**
     * @param array $contactData
     */
    public function submit(array $contactData)
    {
        $contactForm = new ContactForm;
 
        foreach ($contactData as $field => $value) {
            $inputType = $field === 'body' ? 'textarea' : 'input';
            $this->actor->fillField($inputType . '[name="' . $contactForm->formName() . '[' . $field . ']"]', $value);
        }
        $this->actor->click('contact-button');
    }
}
