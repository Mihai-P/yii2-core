<?php

namespace tests\codeception\backend\_pages;

use Yii;
use yii\codeception\BasePage;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
/**
 * Represents loging page
 * @property \tests\codeception\frontend\AcceptanceTester|\tests\codeception\frontend\FunctionalTester|\tests\codeception\backend\AcceptanceTester|\tests\codeception\backend\FunctionalTester $actor
 */
class GeneralPage extends BasePage
{
	function testActivateDeactivate($model) {
		$this->actor->amGoingTo('make the record inactive');
        self::openBy($this->actor);
		$this->actor->click('tr[data-key="'.$model->id.'"] .button-status-deactivate');
		$this->actor->dontSee($model->name, '.grid-view table tr[data-key="'.$model->id.'"] td');

		$this->actor->amGoingTo('look in the inactive records to find it');
		$this->actor->selectOption($this->modelName($model).'Search[status]', 'Inactive');
		$this->actor->click('.start-search');
		$this->actor->see($model->name, '.grid-view table tr[data-key="'.$model->id.'"] td');

		$this->actor->amGoingTo('make the record active');
		$this->actor->click('tr[data-key="'.$model->id.'"] .button-status-activate');
		$this->actor->dontSee($model->name, '.grid-view table tr[data-key="'.$model->id.'"] td');

		$this->actor->amGoingTo('look in the active records to find it');
		$this->actor->selectOption($this->modelName($model).'Search[status]', 'Active');
		$this->actor->click('.start-search');
		$this->actor->see($model->name, '.grid-view table tr[data-key="'.$model->id.'"] td');
	}

	function testUpdate($model, $hasView = false) {
		$this->actor->amGoingTo('test the update for the record');
        self::openBy($this->actor);
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
        self::openBy($this->actor);
		$this->actor->click('tr[data-key="'.$model->id.'"] .button-delete');
		$this->actor->dontSee($model->name, '.grid-view table tr[data-key="'.$model->id.'"] td');
	}

    function testPdf($model) {
        $this->actor->amGoingTo('test the pdf action');
        $this->actor->amOnPage(Yii::$app->getUrlManager()->createUrl([$this->route.'/pdf', 'test' => 1]));
        $this->actor->see($model->name);
    }

	function testCsv($model) {
		$this->actor->amGoingTo('test the csv action');
		$this->actor->amOnPage(Yii::$app->getUrlManager()->createUrl([$this->route.'/csv', 'test' => 1]));
		$this->actor->see($model->name);
	}

    function testView($model) {
        $this->actor->amGoingTo('test the pdf action');
        $this->actor->amOnPage(Yii::$app->getUrlManager()->createUrl([$this->route.'/view', 'id' => $model->id]));
        $this->actor->see($model->name);
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