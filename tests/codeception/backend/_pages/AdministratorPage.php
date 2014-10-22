<?php

namespace tests\codeception\backend\_pages;

/**
 * Represents loging page
 * @property \tests\codeception\frontend\AcceptanceTester|\tests\codeception\frontend\FunctionalTester|\tests\codeception\backend\AcceptanceTester|\tests\codeception\backend\FunctionalTester $actor
 */
class AdministratorPage extends GeneralPage
{
    public $route = 'core/administrator';
}
