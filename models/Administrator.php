<?php

namespace core\models;

use Yii;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "User".
 *
 * @property integer $id
 * @property integer $Group_id
 * @property string $type
 * @property string $password
 * @property string $password_reset_token
 * @property string $auth_key
 * @property string $name
 * @property string $firstname
 * @property string $lastname
 * @property string $picture
 * @property string $email
 * @property string $phone
 * @property string $mobile
 * @property string $validation_key
 * @property integer $login_attempts
 * @property string $status
 * @property string $update_time
 * @property integer $update_by
 * @property string $create_time
 * @property integer $create_by
 *
 */
class Administrator extends User implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules =  ArrayHelper::merge(
            [
                ['type', 'default', 'value' => 'Administrator'],

                [['Group_id', 'login_attempts'], 'integer'],
                [['Group_id'], 'required'],

                [['picture', 'phone', 'mobile'], 'safe'],

                [['picture', 'phone', 'mobile', 'validation_key'], 'string', 'max' => 255],
            ],
            parent::rules()
        );

        if($this->isNewRecord) {
            $rules[] = [['password', 'password_repeat'], 'required'];
        }

        return $rules;

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Group_id' => 'Group',
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
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'Group_id']);
    }

    /**
     * adding a default query to the model
     */
    public static function find()
    {
        return parent::find()->where('type = "Administrator" AND status <> "deleted"');
    }
}