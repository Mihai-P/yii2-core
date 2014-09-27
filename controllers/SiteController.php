<?php

namespace core\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;
use yii\base\Security;
use core\models\LoginForm;
use core\models\Administrator;
use core\models\Email;
use core\components\Controller;

class SiteController extends Controller
{
	/**
	 * @var \core\Module
	 */
	public $module;

	private $loginAttemptsVar = '__LoginAttemptsCount';

	public function behaviors()
	{
		return [
			'access' => [
				'class' => \yii\filters\AccessControl::className(),
				'only' => ['index'],
				'rules' => [
					[
						'actions' => ['index'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}

	public function actionIndex()
	{
		$this->layout = static::FORM_LAYOUT;
		return $this->render('index', []);
	}
}