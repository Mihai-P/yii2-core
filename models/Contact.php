<?php

namespace core\models;

use Yii;
use common\models\Postcode;
use yii\helpers\ArrayHelper;
use core\components\TagsBehavior;
use yii\db\Expression;
use core\models\Tag;

/**
 * This is the model class for table "User".
 *
 * @property integer $id
 * @property string $title
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
 * @property integer $login_attempts
 * @property string $status
 * @property string $update_time
 * @property integer $update_by
 * @property string $create_time
 * @property integer $create_by
 *
 */
class Contact extends  User
{
    var $tags;
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
            [['Group_id', 'login_attempts', 'update_by', 'create_by'], 'integer'],
            [['email', 'firstname', 'lastname'], 'required'],
            [['email'], 'email'],
            [['tags', 'update_time', 'create_time'], 'safe'],
            [['type', 'status'], 'string'],
            [['password', 'name', 'firstname', 'lastname', 'picture', 'email', 'phone', 'mobile'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 128],
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
            'Group_id' => 'Group',
            'type' => 'Type',
            'name' => 'Name',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'picture' => 'Picture',
            'email' => 'Email',
            'phone' => 'Phone',
            'mobile' => 'Mobile',
            'status' => 'Status',
            'update_time' => 'Update Time',
            'update_by' => 'Update By',
            'create_time' => 'Create Time',
            'create_by' => 'Create By',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
            [
                'tags' => [
                    'class' => TagsBehavior::className(),
                ]
            ],
            parent::behaviors()
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModelTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'Tag_id'])
            ->viaTable('Contact_Tag', ['Contact_id' => 'id'], function($query) {
                return $query->where('Contact_Tag.status = "active"');
            });
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->name = $this->firstname . ' ' . $this->lastname;
            if (!empty($this->password_repeat)) {
                $this->password = md5($this->password_repeat);
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
}