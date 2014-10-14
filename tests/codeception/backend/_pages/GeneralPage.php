<?php

namespace tests\codeception\backend\_pages;

use yii\codeception\BasePage;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
/**
 * Represents loging page
 * @property \codeception_frontend\AcceptanceTester|\codeception_frontend\FunctionalTester|\codeception_backend\AcceptanceTester|\codeception_backend\FunctionalTester $actor
 */
class GeneralPage extends BasePage
{
	function testActivateDeactivate($model) {
		$this->actor->amGoingTo('make the record inactive');
		$this->actor->click('tr[data-key="'.$model->id.'"] .button-status-deactivate');
		$this->actor->dontSee($model->name, '.grid-view table tr td');

		$this->actor->amGoingTo('look in the inactive records to find it');
		$this->actor->selectOption($this->modelName($model).'Search[status]', 'Inactive');
		$this->actor->click('.start-search');
		$this->actor->see($model->name, '.grid-view table tr td');

		$this->actor->amGoingTo('make the record active');
		$this->actor->click('tr[data-key="'.$model->id.'"] .button-status-activate');
		$this->actor->dontSee($model->name, '.grid-view table tr td');

		$this->actor->amGoingTo('look in the active records to find it');
		$this->actor->selectOption($this->modelName($model).'Search[status]', 'Active');
		$this->actor->click('.start-search');
		$this->actor->see($model->name, '.grid-view table tr td');
	}

	function testUpdate($model, $hasView = false) {
		$this->actor->amGoingTo('test the update for the record');
		$this->actor->click('tr[data-key="'.$model->id.'"] a[title="Update"]');
		$this->actor->see('Update '.$this->singular($model));
		$this->actor->click('Update');
		if($hasView) {
		  $this->actor->see($model->name, 'h6');
		  $this->actor->click(Inflector::pluralize(Inflector::camel2words(StringHelper::basename(get_class($model)))), '.breadcrumb a');
		}
		$this->actor->see(Inflector::pluralize(Inflector::camel2words(StringHelper::basename(get_class($model)))), 'h6');
	}	

	function testDelete($model) {
		$this->actor->amGoingTo('delete the record');
		$this->actor->click('tr[data-key="'.$model->id.'"] .button-delete');
		$this->actor->dontSee($model->name, '.grid-view table tr td');
	}	

	function modelName($model) {
		return StringHelper::basename(get_class($model));
	}	

	function singular($model) {
		return Inflector::camel2words($this->modelName($model));
	}	

	function plural($model) {
		return Inflector::pluralize($this->singular($model));
	}	

}