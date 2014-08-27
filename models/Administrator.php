<?php

namespace core\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "User".
 *
 * @property integer $id
 * @property string $title
 * @property integer $Group_id
 * @property string $username
 * @property string $type
 * @property string $password
 * @property string $password_reset_token
 * @property string $auth_key
 * @property string $last_visit_time
 * @property string $name
 * @property string $firstname
 * @property string $lastname
 * @property string $picture
 * @property string $email
 * @property string $phone
 * @property string $mobile
 * @property string $fax
 * @property string $company
 * @property string $address
 * @property integer $Postcode_id
 * @property integer $Administrator_id
 * @property integer $Contact_id
 * @property string $comments
 * @property string $internal_comments
 * @property string $break_from
 * @property string $break_to
 * @property string $dob_date
 * @property string $ignore_activity
 * @property string $sms_subscription
 * @property string $email_subscription
 * @property string $validation_key
 * @property integer $login_attempts
 * @property string $status
 * @property string $update_time
 * @property integer $update_by
 * @property string $create_time
 * @property integer $create_by
 *
 * @property Address[] $addresses
 * @property ContactCredit[] $contactCredits
 * @property Delivery[] $deliveries
 * @property Feedback[] $feedbacks
 * @property Invoice[] $invoices
 * @property Order[] $orders
 * @property Administrator $administrator
 * @property Administrator[] $administrators
 * @property Administrator $contact
 * @property Group $group
 * @property Postcode $postcode
 */
class Administrator extends \core\components\ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 'deleted';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_ACTIVE = 'active';

    var $password_repeat;

    private $statuses = [
        self::STATUS_DELETED => 'Deleted',
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
    ];

    public function getStatus($status = null)
    {
        if ($status === null) {
            return $this->statuses[$this->status];
        }
        return $this->statuses[$status];
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
        $rules = [
            ['type', 'default', 'value' => 'Administrator'],
            [['Group_id', 'login_attempts', 'update_by', 'create_by'], 'integer'],
            [['password'], 'compare', 'on' => ['resetPassword', 'update'], 'operator' => '=='],
            [['password', 'password_repeat'], 'validatePasswordInput'],
            [['firstname', 'lastname', 'Group_id', 'email'], 'required'],
            [['update_time', 'create_time'], 'safe'],
            [['email'], 'email'],
            [['type', 'status'], 'string'],
            [['password', 'password_repeat', 'firstname', 'lastname', 'picture', 'email', 'phone', 'mobile', 'validation_key'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 128],
            [['password_reset_token'], 'string', 'max' => 32]
        ];

        if($this->isNewRecord) {
            $rules[] = [['password', 'password_repeat'], 'required'];
        }
        return $rules;

    }

    public function validatePasswordInput($attribute, $params)
    {
        if($this->isNewRecord && (empty($this->password) || empty($this->password_repeat)))  {
            $this->addError('password', 'The password is required');
            $this->addError('password_repeat', 'The password is required');
            return;
        }
        if($this->password != $this->password_repeat) {
            die('The password repeat');
            $this->addError('password', 'You have to repeat the password');
            $this->addError('password_repeat', 'You have to repeat the password');
        }
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'signup' => ['email', 'password'],
            'profile' => ['email', 'password'],
            'resetPassword' => ['password', 'password_repeat'],
            'requestPasswordResetToken' => ['email'],
            'login' => ['last_visit_time'],
        ] + parent::scenarios();
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'Group_id' => 'Group ID',
            'password' => 'Password',
            'password_repeat' => 'Repeat Password',
            'auth_key' => 'Auth Key',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'picture' => 'Picture',
            'email' => 'Email',
            'phone' => 'Phone',
            'mobile' => 'Mobile',
            'validation_key' => 'Validation Key',
            'login_attempts' => 'Login Attempts',
            'status' => 'Status',
            'update_time' => 'Update Time',
            'update_by' => 'Update By',
            'create_time' => 'Create Time',
            'create_by' => 'Create By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasMany(Contact::className(), ['Contact_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'Group_id']);
    }

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
     * Finds user by username
     *
     * @param string $username
     * @return null|User
     */
    public static function findByUsername($username)
    {
        return static::find()
        ->andWhere(['and', ['or', ['username' => $username], ['email' => $username]], ['status' => static::STATUS_ACTIVE]])
        ->one();
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


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->name = $this->firstname . ' ' . $this->lastname;
            if (!empty($this->password_repeat)) {
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            } else {
                unset($this->password);
            }
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->getSecurity()->generateRandomKey();
            }
            if ($this->getScenario() !== \yii\web\User::EVENT_AFTER_LOGIN) {
                $this->setAttribute('update_time', new Expression('CURRENT_TIMESTAMP'));
            }

            return true;
        }
        return false;
    }

    public function login($duration = 0)
    {
        return Yii::$app->user->login($this, $duration);
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    
    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->scenario='';
        $this->password_reset_token = null;
        $this->detachBehavior('blameable');
        $this->detachBehavior('timestamp');        
        $this->save(false);
        return true;
    }    
}