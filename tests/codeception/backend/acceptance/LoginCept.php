<?php

use tests\codeception\backend\AcceptanceTester;
use tests\codeception\backend\_pages\LoginPage;
use tests\codeception\backend\_pages\RequestPasswordResetPage;
use tests\codeception\backend\_pages\ResetPasswordPage;
use core\models\Administrator;

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure login page works');

$loginPage = LoginPage::openBy($I);

$I->amGoingTo('submit login form with no data');
$loginPage->login('', '');
$I->expectTo('see validations errors');
$I->see('Email cannot be blank.', '.help-block');
$I->see('Password cannot be blank.', '.help-block');

/*
$I->amGoingTo('try to login with wrong credentials');
$I->expectTo('see validations errors');
$loginPage->login('Frodo@biti.ro', 'wrong');
$I->expectTo('see validations errors');
$I->see('Incorrect email or password.', '.help-block');

$I->amGoingTo('try to login with correct credentials');
$loginPage->logMeIn();
$I->expectTo('see that user is logged');
$I->see('My Yii Application');
$I->click('Logout');

$loginPage = LoginPage::openBy($I);

$I->amGoingTo('test the password reset');
$I->click('Forgot Password');
$I->see('Reset Password');

$I->amGoingTo('try to reset the password without entering an email address');
$I->click('Reset');
$I->see('Email cannot be blank.', '.help-block');

$I->amGoingTo('try to reset the password with an incorrect email address');
$I->fillField('input[name="Administrator[email]"]', 'Frodo@biti.ro');
$I->click('Reset');
$I->see('There was an error sending the email.');

$I->amGoingTo('try to reset the password with a correct email address');
$I->fillField('input[name="Administrator[email]"]', 'webmaster@2ezweb.com.au');
$I->click('Reset');
$I->see('Check your email for further instructions.');

$admin = Administrator::findOne(['email' => 'webmaster@2ezweb.com.au']);

$I->amGoingTo('try the reset password page with a wrong token');
$resetPasswordPage = ResetPasswordPage::openBy($I, ['token' => 'mordor']);
$I->see('Wrong password reset token.');

$I->amGoingTo('try the reset password page with a good token');
$resetPasswordPage = ResetPasswordPage::openBy($I, ['token' => $admin->password_reset_token]);
$I->dontSee('Wrong password reset token.');
$I->see('Reset Password');

$I->amGoingTo('try to change the actual password but not entering anything');
$resetPasswordPage->submit('');
$I->see('Password cannot be blank.');
$I->see('Repeat Password cannot be blank.');

$I->amGoingTo('try to change the actual password but repeating it properly');
$resetPasswordPage->submit('Frodo', 'Baggins');
$I->see('You have to repeat the password.');

$I->amGoingTo('try to change the actual password but repeating it properly');
$resetPasswordPage->submit('Frodo', 'Frodo');
$I->see('New password was saved.');
$loginPage->login(LoginPage::$username, 'Frodo');
$I->expectTo('see that user is logged');
$I->see('My Yii Application');
$I->click('Logout');

$admin->new_password = LoginPage::$password;
$admin->new_password_repeat = LoginPage::$password;
$admin->save();

$loginPage->logMeIn();
$I->expectTo('see that user is logged');
$I->see('My Yii Application');
$I->click('Logout');
*/