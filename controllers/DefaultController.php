<?php

namespace core\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\HttpException;
use yii\base\Security;
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
				'class' => \yii\filters\AccessControl::className(),
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
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	public function actionLogin()
	{
		$this->layout = '//login';
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
		$this->layout = '//login';
		$model = new Administrator();
		$model->scenario = 'requestPasswordResetToken';
		if ($model->load($_POST) && $model->validate()) {
			if ($this->sendPasswordResetEmail($model->email)) {
				Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');
				return $this->goHome();
			} else {
				Yii::$app->getSession()->setFlash('danger', 'There was an error sending email.');
			}
		} 
		return $this->render('requestPasswordResetToken', [
			'model' => $model,
		]);
	}

	public function actionResetPassword($token)
	{
		$this->layout = '//login';
		$model = Administrator::findOne([
			'password_reset_token' => $token,
			'status' => Administrator::STATUS_ACTIVE,
		]);

		if (!$model) {
			throw new BadRequestHttpException('Wrong password reset token.');
		}

		$model->scenario = 'resetPassword';
		if ($model->load($_POST) && $model->save()) {
			Yii::$app->getSession()->setFlash('success', 'New password was saved.');
			return $this->goHome();
		}
		$model->password = null;
		return $this->render('resetPassword', [
			'model' => $model,
		]);
	}

	private function sendPasswordResetEmail($email)
	{
		$user = Administrator::findOne([
			'status' => Administrator::STATUS_ACTIVE,
			'email' => $email,
		]);

		if (!$user) {
			return false;
		}

		$user->password_reset_token = Yii::$app->getSecurity()->generateRandomKey();
		if ($user->save(false)) {
			Email::create()
				->html($this->renderPartial('/emails/passwordResetToken', ['user' => $user]))
				->subject("Reset Password")
				->send_to(['email' => $user->email, 'name'=> $user->name])
				->send();
			return true;
		}

		return false;
	}
}
