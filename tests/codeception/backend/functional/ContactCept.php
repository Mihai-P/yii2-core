<?php
use tests\codeception\backend\FunctionalTester;
use tests\codeception\backend\_pages\LoginPage;
use tests\codeception\backend\_pages\ContactPage;
use core\models\Contact;

$I = new FunctionalTester($scenario);

LoginPage::openBy($I)->logMeIn($I);

$I->wantTo('test the contact list');

$page = ContactPage::openBy($I);
$I->see('Contacts', 'h6');
$I->see('No results found.');

$I->amGoingTo('add a new record.');
$I->click('Add new');
$I->see('Create Contact');
$I->fillField('input[name="Contact[firstname]"]', 'Frodo');
$I->fillField('input[name="Contact[lastname]"]', 'Baggins');

$I->amGoingTo('submit the form with errors.');
$I->click('Create');
$I->see('Email cannot be blank.', '.help-block');

$I->amGoingTo('submit the form without errors.');
$I->fillField('input[name="Contact[email]"]', 'Frodo.Baggins@Shire.com');
$I->click('Create');
$I->see('Contacts', 'h6');
$I->dontSee('No results found.');

$model = Contact::findOne(['email' => 'Frodo.Baggins@Shire.com']);
$page->testActivateDeactivate($model);

$I->amGoingTo('test the bulk assign to tags');
$page = ContactPage::openBy($I);
$I->submitForm('#assign-tags-form', ['Contact' => [
    'tags' => 'Orc,Wraith',
]]);
$model = Contact::findOne(['email' => 'Frodo.Baggins@Shire.com']);
\PHPUnit_Framework_Assert::assertTrue(count($model->modelTags)==2);

$page->testUpdate($model);
$page->testPdf($model);
$page->testView($model);
$page = ContactPage::openBy($I);

$I->amGoingTo('test the password update.');
$I->click('tr[data-key="'.$model->id.'"] a[title="Update"]');
$I->fillField('input[name="Contact[tags]"]', 'Fiction,Fantasy');
$I->click('Update');
$I->see('Contacts', 'h6');

$I->amGoingTo('filter on a tag to see the models');
$I->selectOption('ContactSearch[tag]', 'Fiction');
$I->click('.start-search');
$I->see($model->name, '.grid-view table tr td');

$page->testDelete($model);