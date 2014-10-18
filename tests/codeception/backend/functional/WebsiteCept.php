<?php
use tests\codeception\backend\FunctionalTester;
use tests\codeception\backend\_pages\LoginPage;
use tests\codeception\backend\_pages\WebsitePage;

$I = new FunctionalTester($scenario);

LoginPage::openBy($I)->logMeIn($I);

$I->wantTo('test the website update');

$page = WebsitePage::openBy($I);
$I->see('Misc', 'h6');

$I->amGoingTo('save the page settings.');
$I->click('Update');
