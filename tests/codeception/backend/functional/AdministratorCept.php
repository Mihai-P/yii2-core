<?php
use tests\codeception\backend\FunctionalTester;
use tests\codeception\backend\_pages\LoginPage;
use tests\codeception\backend\_pages\AdministratorPage;
use core\models\Administrator;

$I = new FunctionalTester($scenario);

LoginPage::openBy($I)->logMeIn($I);

$I->wantTo('test the administrator list');

$page = AdministratorPage::openBy($I);
$I->see('Administrators', 'h6');

$I->amGoingTo('add a new record.');
$I->click('Add new');
$I->see('Create Administrator');
$I->fillField('input[name="Administrator[firstname]"]', 'Sam');
$I->fillField('input[name="Administrator[lastname]"]', 'Gamgee');

$I->amGoingTo('submit the form with errors.');
$I->click('Create');
$I->see('Email cannot be blank.', '.help-block');

$I->amGoingTo('submit the form with errors.');
$I->fillField('input[name="Administrator[email]"]', 'Sam.Gamgee@Shire.com');
$I->click('Create');
$I->see('Password cannot be blank.', '.help-block');
$I->amGoingTo('submit the form without errors.');
$I->fillField('input[name="Administrator[new_password]"]', 'Sam123');
$I->fillField('input[name="Administrator[new_password_repeat]"]', 'Sam123');
$I->selectOption('Administrator[Group_id]', 'Super Admin');
$I->click('Create');
$I->see('Administrators', 'h6');
$I->see('Sam Gamgee', '.grid-view table tr td');

$model = Administrator::findOne(['email' => 'Sam.Gamgee@Shire.com']);
$page->testActivateDeactivate($model);
$page->testUpdate($model);

$I->amGoingTo('test the password update.');
$I->click('tr[data-key="'.$model->id.'"] a[title="Update"]');
$I->fillField('input[name="Administrator[new_password]"]', 'Sam123');
$I->click('Update');
$I->see('You have to repeat the password', '.help-block');
$I->fillField('input[name="Administrator[new_password]"]', '');
$I->click('Update');
$I->see('Administrators', 'h6');

$page->testDelete($model);