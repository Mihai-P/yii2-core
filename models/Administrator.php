<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "User".
 *
 * @property integer $id
 * @property string $title
 * @property integer $Group_id
 * @property string $username
 * @property integer $is_admin
 * @property string $password
 * @property string $password_hash
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
class Administrator extends \yii\db\ActiveRecord
{
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
            [['Group_id', 'is_admin', 'Postcode_id', 'Administrator_id', 'Contact_id', 'login_attempts', 'update_by', 'create_by'], 'integer'],
            [['last_visit_time', 'email'], 'required'],
            [['last_visit_time', 'break_from', 'break_to', 'dob_date', 'update_time', 'create_time'], 'safe'],
            [['comments', 'internal_comments', 'ignore_activity', 'sms_subscription', 'email_subscription', 'status'], 'string'],
            [['title', 'username', 'password', 'name', 'firstname', 'lastname', 'picture', 'email', 'phone', 'mobile', 'fax', 'company', 'address', 'validation_key'], 'string', 'max' => 255],
            [['password_hash', 'auth_key'], 'string', 'max' => 128],
            [['password_reset_token'], 'string', 'max' => 32]
        ];
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
            'username' => 'Username',
            'is_admin' => 'Is Admin',
            'password' => 'Password',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'auth_key' => 'Auth Key',
            'last_visit_time' => 'Last Visit Time',
            'name' => 'Name',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'picture' => 'Picture',
            'email' => 'Email',
            'phone' => 'Phone',
            'mobile' => 'Mobile',
            'fax' => 'Fax',
            'company' => 'Company',
            'address' => 'Address',
            'Postcode_id' => 'Postcode ID',
            'Administrator_id' => 'Administrator ID',
            'Contact_id' => 'Contact ID',
            'comments' => 'Comments',
            'internal_comments' => 'Internal Comments',
            'break_from' => 'Break From',
            'break_to' => 'Break To',
            'dob_date' => 'Dob Date',
            'ignore_activity' => 'Ignore Activity',
            'sms_subscription' => 'Sms Subscription',
            'email_subscription' => 'Email Subscription',
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
}