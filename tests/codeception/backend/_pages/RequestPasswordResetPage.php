<?php

namespace tests\codeception\backend\_pages;

use yii\codeception\BasePage;

/**
 * Represents loging page
 * @property \tests\codeception\frontend\AcceptanceTester|\tests\codeception\frontend\FunctionalTester|\tests\codeception\backend\AcceptanceTester|\tests\codeception\backend\FunctionalTester $actor
 */
class RequestPasswordResetPage extends BasePage
{
    public $route = 'core/default/request-password-reset';
}