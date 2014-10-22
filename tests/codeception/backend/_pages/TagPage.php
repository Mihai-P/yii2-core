<?php

namespace tests\codeception\backend\_pages;

/**
 * Represents the tag page
 * @property \tests\codeception\backend\AcceptanceTester|\tests\codeception\frontend\FunctionalTester|\tests\codeception\backend\AcceptanceTester|\tests\codeception\backend\FunctionalTester $actor
 */
class TagPage extends GeneralPage
{
    public $route = 'core/tag';
    public $name = 'Tag';
}
