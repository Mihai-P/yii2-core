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
    var $password_repeat;
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
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
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
			['email', 'exist', 'message' => 'There was an error sending the email.', 'on' => 'requestPasswordResetToken'],

            [['firstname', 'lastname', 'email'], 'required'],

            [['firstname', 'lastname', 'type', 'status'], 'string', 'max' => 255],

            [['update_by', 'create_by'], 'integer'],

            [['auth_key'], 'string', 'max' => 128],
            [['password_reset_token'], 'string', 'max' => 32],

            [['password'], 'compare', 'on' => ['resetPassword', 'update'], 'operator' => '=='],
            [['password', 'password_repeat'], 'validatePasswordInput'],
            [['password', 'password_repeat'], 'required', 'on' => ['resetPassword']],
		];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'profile' => ['email', 'password'],
            'resetPassword' => ['password', 'password_repeat'],
            'requestPasswordResetToken' => ['email'],
        ] + parent::scenarios();
    }

    public function validatePasswordInput()
    {
        if($this->isNewRecord && (empty($this->password) || empty($this->password_repeat)))  {
            $this->addError('password', 'The password is required');
            $this->addError('password_repeat', 'The password is required');
            return;
        }
        if($this->password != $this->password_repeat) {
            $this->addError('password', 'You have to repeat the password');
            $this->addError('password_repeat', 'You have to repeat the password');
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
            if (!empty($this->password_repeat)) {
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
                $this->password_reset_token = null;
            } else {
                unset($this->password);
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
}
