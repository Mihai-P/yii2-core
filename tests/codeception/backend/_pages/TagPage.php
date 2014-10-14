<?php

namespace tests\codeception\backend\_pages;

/**
 * Represents loging page
 * @property \codeception_frontend\AcceptanceTester|\codeception_frontend\FunctionalTester|\codeception_backend\AcceptanceTester|\codeception_backend\FunctionalTester $actor
 */
class TagPage extends GeneralPage
{
    public $route = 'core/tag';
    public $name = 'Tag';
}
