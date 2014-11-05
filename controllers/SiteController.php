<?php

namespace core\controllers;

use Yii;
use yii\filters\AccessControl;
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
				'class' => AccessControl::className(),
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
    public function beforeAction($event)
    {
        if(Yii::$app->user->isGuest) {
            $this->layout = '@core/views/layouts/login';
        } else {
            $this->layout = static::FORM_LAYOUT;
        }
        return true && parent::beforeAction($event);
    }
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'view' => 'error'
            ],
        ];
    }
	public function actionIndex()
	{
		return $this->render('index', []);
	}
}