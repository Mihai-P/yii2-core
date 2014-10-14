<?php

namespace tests\codeception\backend\_pages;

use yii\codeception\BasePage;

/**
 * Represents loging page
 * @property \codeception_frontend\AcceptanceTester|\codeception_frontend\FunctionalTester|\codeception_backend\AcceptanceTester|\codeception_backend\FunctionalTester $actor
 */
class ResetPasswordPage extends BasePage
{
    public $route = 'core/default/reset-password';

    /**
     * @param string $password
     * @param string $repeat_password
     */
    public function submit($password, $repeat_password = '')
    {
        $this->actor->fillField('input[name="Administrator[new_password]"]', $password);
        $this->actor->fillField('input[name="Administrator[new_password_repeat]"]', $repeat_password ?: $password);
        $this->actor->click('Reset');
    }    
}