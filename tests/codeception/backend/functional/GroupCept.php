<?php
use tests\codeception\backend\FunctionalTester;
use tests\codeception\backend\_pages\LoginPage;
use tests\codeception\backend\_pages\GroupPage;
use core\models\Group;

$I = new FunctionalTester($scenario);

LoginPage::openBy($I)->logMeIn($I);

$I->wantTo('test the group list');

$page = GroupPage::openBy($I);
$I->see('Groups', 'h6');

$I->amGoingTo('add a new record.');
$I->click('Add new');
$I->see('Create Group');
$I->amGoingTo('submit the form with errors.');
$I->click('Create');
$I->see('Name cannot be blank.', '.help-block');

$I->amGoingTo('submit the form without errors.');
$I->fillField('input[name="Group[name]"]', 'Hobbit');
$I->click('Create');
$I->see('Groups', 'h6');
$I->see('Hobbit', '.grid-view table tr td');

$model = Group::findOne(['name' => 'Hobbit']);
$page->testActivateDeactivate($model);
$page->testUpdate($model);
$page->testDelete($model);