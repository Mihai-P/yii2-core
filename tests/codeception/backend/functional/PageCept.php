<?php

use tests\codeception\backend\FunctionalTester;
use tests\codeception\backend\_pages\LoginPage;
use tests\codeception\backend\_pages\PagePage;
use core\models\Page;
use core\models\PageTemplate;

$I = new FunctionalTester($scenario);

LoginPage::openBy($I)->logMeIn($I);

$I->wantTo('test the Page list');

$page = PagePage::openBy($I);
$I->see('Pages', 'h6');
$I->see('No results found.');

$pageTemplate = new PageTemplate;
$pageTemplate->name = 'Main';
$pageTemplate->save();

$pageModel = new Page;
$pageModel->PageTemplate_id = $pageTemplate->id;
$pageModel->name = 'Minas';
$pageModel->template = '_test';
$pageModel->save();

$I->amGoingTo('add a new record.');
$I->click('Add new');
$I->see('Create Page');

$I->amGoingTo('submit the form with errors.');
$I->click('Create');
$I->see('Name cannot be blank.', '.help-block');

$I->amGoingTo('submit the form without errors.');
$I->fillField('input[name="Page[name]"]', 'Rivendale');
$I->selectOption('select[name="Page[PageTemplate_id]"]', 'Main');
$I->click('Create');
if(count(Yii::$app->getModule('core')->pageTemplates) > 1) {
    $I->click('Update');
}

$I->see('Rivendale', 'h6');
$page = PagePage::openBy($I);

$page->testUpdate($pageModel, true);
$pageModel->template = '_notExisting';
$pageModel->save();
$page->testUpdate($pageModel, true);

$model = Page::find()->where(['name' => 'Rivendale'])->orderBy(['create_time' => SORT_DESC])->one();
$page->testActivateDeactivate($model);
$page->testUpdate($model, true);
$page->testPdf($model);
$page->testView($model);

$I->amGoingTo('test the seo saving widget');
$I->amOnPage(Yii::$app->getUrlManager()->createUrl([$page->route.'/view', 'id' => $model->id]));
$I->see($model->name);

$I->submitForm('#seo', ['Seo' => [
    'meta_title' => 'MetaTitle',
    'meta_keywords' => 'MetaKeywords',
    'meta_description' => 'MetaDescription',
]]);
$I->amOnPage(Yii::$app->getUrlManager()->createUrl([$page->route.'/view', 'id' => $model->id]));
$I->see('MetaKeywords');

$page->testDelete($model);