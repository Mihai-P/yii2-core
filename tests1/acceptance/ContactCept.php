<?php
//use tests\acceptance\AcceptanceTester;
use core\tests\_pages\LoginPage;
use core\tests\_pages\ContactPage;

$I = new AcceptanceTester($scenario);

LoginPage::openBy($I)->logMeIn($I);

$I->wantTo('test the contact list');

$contactPage = ContactPage::openBy($I);
$I->see('Contacts');
$I->see('No results found.');
$I->click('Add new');
$I->see('Create Contact');
$I->fillField('input[name="Contact[firstname]"]', 'Frodo');
$I->fillField('input[name="Contact[lastname]"]', 'Baggins');
$I->fillField('input[name="Contact[email]"]', 'Frodo.Baggins@Shire.com');
$I->click('Create');
$I->see('Contacts');
$I->dontSee('No results found.');