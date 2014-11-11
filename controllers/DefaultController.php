<?php

namespace core\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use core\components\Controller;
use core\models\PasswordResetRequestForm;
use core\models\ResetPasswordForm;
use yii\filters\AccessControl;
use core\models\LoginForm;

/**
 * Class DefaultController
 * @package core\controllers
 */
class DefaultController extends Controller
{
	/**
	 * @var \core\Module
	 */
	public $module;

    /**
     * @var int the number of login attempts done.
     */

    private $loginAttemptsVar = '__LoginAttemptsCount';

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				//'only' => ['logout', 'login', 'request-password-reset', 'reset-password'],
				'rules' => [
                    [
                        'actions' => ['login', 'request-password-reset', 'reset-password'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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

    /**
     * @param \yii\base\Action $event
     * @return bool
     */
    public function beforeAction($event)
    {
		if(Yii::$app->user->isGuest) {
			$this->layout = self::LOGIN_LAYOUT;
		} else {
            $this->layout = self::MAIN_LAYOUT;
		}
        return parent::beforeAction($event);
    }

    /**
     * Shows the login form
     *
     * @return string|\yii\web\Response
     */
	public function actionLogin()
	{
		$model = new LoginForm();
		//make the captcha required if the unsuccessful attempts are more of thee
		if ($this->getLoginAttempts() >= $this->module->attemptsBeforeCaptcha) {
			$model->scenario = 'withCaptcha';
		}

        if(Yii::$app->request->post()) {
            if($model->load($_POST) && $model->login()) {
                $this->setLoginAttempts(0); //if login is successful, reset the attempts
                return $this->goBack();
            } else {
                //if login is not successful, increase the attempts
                $this->setLoginAttempts($this->getLoginAttempts() + 1);
            }
		}

		return $this->render('login', [
			'model' => $model,
		]);
	}

    /**
     * @return int
     */
    private function getLoginAttempts()
	{
		return Yii::$app->getSession()->get($this->loginAttemptsVar, 0);
	}

    /**
     * @param $value - the number of login attempts
     */
    private function setLoginAttempts($value)
	{
		Yii::$app->getSession()->set($this->loginAttemptsVar, $value);
	}

    /**
     * Logs an Admin out
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
	{
		Yii::$app->user->logout();
		return $this->goHome();
	}

    /**
     * Shows the request reset password form
     *
     * @return string|\yii\web\Response
     */
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

    /**
     * Allows an Administrator with the correct token to update the password
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return string|\yii\web\Response
     */

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
