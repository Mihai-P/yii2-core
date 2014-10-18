<?php
use tests\codeception\backend\FunctionalTester;
use tests\codeception\backend\_pages\LoginPage;
use tests\codeception\backend\_pages\MenuPage;
use core\models\Menu;

$I = new FunctionalTester($scenario);

LoginPage::openBy($I)->logMeIn($I);

$I->wantTo('test the Menu list');

$page = MenuPage::openBy($I);
$I->see('Menus', 'h6');

$I->amGoingTo('add a new record.');
$I->click('Add new');
$I->see('Create Menu');

$I->amGoingTo('submit the form with errors.');
$I->click('Create');
$I->see('Name cannot be blank.', '.help-block');

$I->amGoingTo('submit the form without errors.');
$I->fillField('input[name="Menu[name]"]', 'Mordor');
$I->click('Create');
$I->see('Menus', 'h6');

$model = Menu::find()->where(['name' => 'Mordor'])->orderBy(['create_time' => SORT_DESC])->one();
$page->testActivateDeactivate($model);
$page->testUpdate($model);
$page->testPdf($model);
$page->testView($model);
$page->testDelete($model);

$page = MenuPage::openBy($I);

$I->click('Add new');
$I->fillField('input[name="Menu[name]"]', 'Shire');
$I->click('Create');

$model = Menu::findOne(['name' => 'Shire']);
$I->click('Add new');
$I->fillField('input[name="Menu[name]"]', 'Hobbiton');
$I->selectOption('Menu[Menu_id]', $model->id);
$I->click('Create');

$I->click('Add new');
$I->fillField('input[name="Menu[name]"]', 'Bree');
$I->selectOption('Menu[Menu_id]', $model->id);
$I->click('Create');

$I->selectOption('MenuSearch[Menu_id]', $model->id);
$I->click('.start-search');
$I->see('Sort', 'a.btn-success');
$I->click('Sort');


$modelHobbiton = Menu::findOne(['name' => 'Hobbiton']);
$modelBree = Menu::findOne(['name' => 'Bree']);
\PHPUnit_Framework_Assert::assertTrue($modelHobbiton->lft < $modelBree->lft);

$I->submitForm('#sort-form', ['Menu' => [$modelBree->id, $modelHobbiton->id]]);
$modelHobbiton = Menu::findOne(['name' => 'Hobbiton']);
$modelBree = Menu::findOne(['name' => 'Bree']);
\PHPUnit_Framework_Assert::assertTrue($modelHobbiton->lft > $modelBree->lft);
