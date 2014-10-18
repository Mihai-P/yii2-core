<?php

namespace tests\codeception\backend\_pages;

use yii\codeception\BasePage;
/**
 * Represents loging page
 * @property \codeception_frontend\AcceptanceTester|\codeception_frontend\FunctionalTester|\codeception_backend\AcceptanceTester|\codeception_backend\FunctionalTester $actor
 */
class GeneralPage extends BasePage
{
    public $route = 'core/website/update?id=1';
}