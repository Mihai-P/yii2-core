<?php
use tests\codeception\backend\FunctionalTester;
use tests\codeception\backend\_pages\LoginPage;
use tests\codeception\backend\_pages\TagPage;
use core\models\Tag;

$I = new FunctionalTester($scenario);

LoginPage::openBy($I)->logMeIn($I);

$I->wantTo('test the Tag list');

$page = TagPage::openBy($I);
$I->see('Tags', 'h6');

$tag = new Tag;
$tag->name = 'Rohan';
$tag->type = 'Contact';
$tag->save();

$I->amGoingTo('add a new record.');
$I->click('Add new');
$I->see('Create Tag');
$I->fillField('select[name="Tag[type]"]', 'Contact');

$I->amGoingTo('submit the form with errors.');
$I->click('Create');
$I->see('Name cannot be blank.', '.help-block');

$I->amGoingTo('submit the form without errors.');
$I->fillField('input[name="Tag[name]"]', 'Gondor');
$I->click('Create');
$I->see('Tags', 'h6');
$I->see('Gondor', '.grid-view table tr td');

$model = Tag::find()->where(['name' => 'Gondor'])->orderBy(['create_time' => SORT_DESC])->one();
$page->testActivateDeactivate($model);
$page->testUpdate($model);
$page->testPdf($model);
$page->testView($model);
$page->testDelete($model);