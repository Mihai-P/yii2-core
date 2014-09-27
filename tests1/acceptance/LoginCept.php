<?php

//use tests\codeception\backend\AcceptanceTester;
use core\tests\_pages\LoginPage;

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure login page works');

$loginPage = LoginPage::openBy($I);

$I->amGoingTo('submit login form with no data');
$loginPage->login('', '');
$I->expectTo('see validations errors');
$I->see('Email cannot be blank.', '.help-block');
$I->see('Password cannot be blank.', '.help-block');

$I->amGoingTo('try to login with wrong credentials');
$I->expectTo('see validations errors');
$loginPage->login('Frodo@biti.ro', 'wrong');
$I->expectTo('see validations errors');
$I->see('Incorrect email or password.', '.help-block');

$I->amGoingTo('try to login with correct credentials');
$loginPage->login('webmaster@2ezweb.com.au', 'admin');
$I->expectTo('see that user is logged');
$I->seeLink('Logout');
$I->dontSeeLink('Login');
/** Uncomment if using WebDriver
 * $I->click('Logout (erau)');
 * $I->dontSeeLink('Logout (erau)');
 * $I->seeLink('Login');
 */
