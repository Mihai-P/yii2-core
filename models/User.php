<?php

namespace core\models;

use Yii;
use yii\web\IdentityInterface;
use core\components\ActiveRecord;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "User".
 *
 * @property integer $id
 * @property string $name
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $password
 * @property string $password_reset_token
 * @property string $auth_key
 * @property integer $status
 * @property string $last_visit_time
 * @property string $create_time
 * @property string $update_time
 * @property string $delete_time
 *
 * @property ProfileFieldValue $profileFieldValue
 */
class User extends ActiveRecord implements IdentityInterface
{
    var $new_password;
    var $new_password_repeat;
    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

	/**
	 * Finds user by email
	 *
	 * @param string $email
	 * @return null|User
	 */
	public static function findByEmail($email)
	{
		return static::findOne(['email' => $email, 'status' => static::STATUS_ACTIVE]);
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
	}

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

	/**
	 * @return int|string current user ID
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string current user auth key
	 */
	public function getAuthKey()
	{
		return $this->auth_key;
	}

	/**
	 * @param string $authKey
	 * @return boolean if auth key is valid for current user
	 */
	public function validateAuthKey($authKey)
	{
		return $this->auth_key === $authKey;
	}

	/**
	 * @param string $password password to validate
	 * @return bool if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'User';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['status', 'default', 'value' => static::STATUS_ACTIVE, 'on' => 'signup'],
			['status', 'safe'],

			['email', 'filter', 'filter' => 'trim'],
			['email', 'email'],

            [['firstname', 'lastname', 'email'], 'required'],

            [['firstname', 'lastname', 'type', 'status'], 'string', 'max' => 255],

            [['update_by', 'create_by'], 'integer'],

            [['auth_key'], 'string', 'max' => 128],

            [['new_password', 'new_password_repeat'], 'validatePasswordInput'],
		];
	}

    public function validatePasswordInput()
    {
        if($this->isNewRecord && (empty($this->new_password) || empty($this->new_password_repeat)))  {
            $this->addError('new_password', 'The password is required.');
            $this->addError('new_password_repeat', 'The password is required.');
            return;
        }
        if($this->new_password != $this->new_password_repeat) {
            $this->addError('new_password', 'You have to repeat the password.');
            $this->addError('new_password_repeat', 'You have to repeat the password.');
        }
    }

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'email' => Yii::t('core.user', 'Email'),
			'password' => Yii::t('core.user', 'Password'),
            'new_password' => Yii::t('core.user', 'New Password'),
            'new_password_repeat' => Yii::t('core.user', 'Repeat Password'),
			'password_reset_token' => Yii::t('core.user', 'Password Reset Token'),
			'auth_key' => Yii::t('core.user', 'Auth Key'),
			'status' => Yii::t('core.user', 'Status'),
			'last_visit_time' => Yii::t('core.user', 'Last Visit Time'),
			'create_time' => Yii::t('core.user', 'Create Time'),
			'update_time' => Yii::t('core.user', 'Update Time'),
			'delete_time' => Yii::t('core.user', 'Delete Time'),
		];
	}

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->name = $this->firstname . ' ' . $this->lastname;
            if (!empty($this->new_password)) {
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->new_password);
                $this->password_reset_token = null;
            } else {
                unset($this->new_password);
            }
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->getSecurity()->generateRandomKey();
            }

            return true;
        }
        return false;
    }

    /**
     * Login the model
     *
     * @param int $duration how long to keep the user logged in. 0 is forever
     * @return bool if the login was successful
     */
    public function login($duration = 0)
    {
        return Yii::$app->user->login($this, $duration);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}