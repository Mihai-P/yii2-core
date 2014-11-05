<?php

namespace core\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use core\models\PasswordResetRequestForm;
use core\models\ResetPasswordForm;
use yii\filters\AccessControl;
use core\models\LoginForm;
use core\models\Administrator;
use core\models\Email;

class DefaultController extends Controller
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
				'only' => ['logout'],
				'rules' => [
					[
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}

	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
				'view' => 'error'
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

    public function beforeAction($event)
    {
		if(Yii::$app->user->isGuest) {
			$this->layout = '@core/views/layouts/login';
		} else {
			$this->layout = '@core/views/layouts/main';
		}
        return true;
    }

	public function actionLogin()
	{
		$this->layout = '@core/views/layouts/login';
		if (!\Yii::$app->user->isGuest) {
			$this->goHome();
		}

		$model = new LoginForm();

		//make the captcha required if the unsuccessful attempts are more of thee
		if ($this->getLoginAttempts() >= $this->module->attemptsBeforeCaptcha) {
			$model->scenario = 'withCaptcha';
		}

		if ($model->load($_POST) and $model->login()) {
			$this->setLoginAttempts(0); //if login is successful, reset the attempts
			return $this->goBack();
		}
		//if login is not successful, increase the attempts
		$this->setLoginAttempts($this->getLoginAttempts() + 1);

		return $this->render('login', [
			'model' => $model,
		]);
	}

	private function getLoginAttempts()
	{
		return Yii::$app->getSession()->get($this->loginAttemptsVar, 0);
	}

	private function setLoginAttempts($value)
	{
		Yii::$app->getSession()->set($this->loginAttemptsVar, $value);
	}

	public function actionLogout()
	{
		Yii::$app->user->logout();
		return $this->goHome();
	}

	public function actionRequestPasswordReset()
	{
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }
        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
	}

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');
            return $this->goHome();
        }
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
