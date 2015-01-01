<?php
use tests\codeception\backend\FunctionalTester;
use tests\codeception\backend\_pages\LoginPage;
use tests\codeception\backend\_pages\BookmarkPage;
use core\models\Bookmark;

$I = new FunctionalTester($scenario);

LoginPage::openBy($I)->logMeIn($I);

$I->wantTo('test the Bookmark list');

$page = BookmarkPage::openBy($I);
$I->see('Bookmarks', 'h6');

$I->amGoingTo('add a new record.');
$I->click('Add new');
$I->see('Create Bookmark');
$I->amGoingTo('submit the form with errors.');
$I->click('Create');
$I->see('Name cannot be blank.', '.help-block');
$I->see('Url cannot be blank.', '.help-block');

$I->amGoingTo('submit the form without errors.');
$I->fillField('input[name="Bookmark[name]"]', 'Hobbit');
$I->fillField('input[name="Bookmark[url]"]', '/');
$I->click('Create');
$I->see('Bookmarks', 'h6');
$I->see('Hobbit', '.grid-view table tr td');

$model = Bookmark::find()->where(['name' => 'Hobbit'])->orderBy(['create_time' => SORT_DESC])->one();
$page->testActivateDeactivate($model);
$page->testUpdate($model);
$page->testPdf($model);
$page->testCsv($model);
$page->testView($model);
$page->testDelete($model);