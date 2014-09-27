<?php

namespace core\tests\_pages;

use yii\codeception\BasePage;

/**
 * Represents loging page
 * @property \codeception_frontend\AcceptanceTester|\codeception_frontend\FunctionalTester|\codeception_backend\AcceptanceTester|\codeception_backend\FunctionalTester $actor
 */
class LoginPage extends BasePage
{
    public $route = 'core/default/login';

    /**
     * @param string $username
     * @param string $password
     */
    public function login($username, $password)
    {
        $this->actor->fillField('input[name="LoginForm[email]"]', $username);
        $this->actor->fillField('input[name="LoginForm[password]"]', $password);
        $this->actor->click('Login');
    }

    public static $username = 'webmaster@2ezweb.com.au';
    public static $password = 'admin';

    public function logMeIn()
    {
        $this->login(self::$username, self::$password);
    }       
}
