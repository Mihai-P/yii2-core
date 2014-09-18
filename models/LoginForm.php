<?php

namespace core\models;

use Yii;
use yii\base\Model;
use core\models\User;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
	public $email;
	public $password;
	public $rememberMe = true;
	public $verifyCode;

	private $_user = false;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			// email and password are both required
			[['email', 'password'], 'required'],
			[['email'], 'email'],
			// password is validated by validatePassword()
			['password', 'validatePassword'],
			// rememberMe must be a boolean value
			['rememberMe', 'boolean'],
			['verifyCode', 'captcha', 'captchaAction' => 'core/default/captcha', 'on' => 'withCaptcha'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'email' => Yii::t('core.user', 'Email'),
			'password' => Yii::t('core.user', 'Password'),
			'rememberMe' => Yii::t('core.user', 'Remember Me'),
			'verifyCode' => Yii::t('core.user', 'Verify Code'),
		];
	}


	/**
	 * Validates the password.
	 * This method serves as the inline validation for password.
	 */
	public function validatePassword()
	{
		$user = $this->getUser();
		if (!$user || !$user->validatePassword($this->password)) {
			$this->addError('password', Yii::t('core.user', 'Incorrect email or password.'));
		}
	}

	/**
	 * Logs in a user using the provided email and password.
	 *
	 * @return boolean whether the user is logged in successfully
	 */
	public function login()
	{
		if ($this->validate()) {
			return $this->getUser()->login($this->rememberMe ? Yii::$app->getModule('core')->rememberMeTime : 0);
		} else {
			return false;
		}
	}

	/**
	 * Finds user by [[email]]
	 *
	 * @return User|null
	 */
	private function getUser()
	{
		if ($this->_user === false) {
			$this->_user = Administrator::findByEmail($this->email);
		}
		return $this->_user;
	}
}
