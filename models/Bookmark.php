<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "Bookmark".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $reminder
 * @property string $description
 * @property integer $order
 * @property string $status
 * @property string $update_time
 * @property integer $update_by
 * @property string $create_time
 * @property integer $create_by
 *
 * @property User $createBy
 */
class Bookmark extends \core\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Bookmark';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url'], 'required'],
            [['reminder', 'update_time', 'create_time'], 'safe'],
            [['description'], 'string'],
            [['order', 'update_by', 'create_by'], 'integer'],
            [['name', 'url', 'status'], 'string', 'max' => 255]
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->reminder = $this->reminder ? date('Y-m-d H:i:s', strtotime($this->reminder)) : null;
            return true;
        }
        return false;
    }


    public function afterFind()
    {
        $this->reminder = $this->reminder ? Yii::$app->formatter->asDateTime($this->reminder, 'MMM dd, yyyy hh:mm a') : '';
        parent::afterFind();
    }

    public function getTypeIcon()
    {
        if($this->reminder) {
            if(strtotime($this->reminder) >= time()) {
                return 'reminder';
            } else {
                return 'passed-reminder';
            }
        } else {
            return 'bookmark';
        }
    }

    public function hasExpired()
    {
        if($this->reminder) {
            if(strtotime($this->reminder) >= time()) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'url' => 'Url',
            'reminder' => 'Reminder',
            'description' => 'Description',
            'order' => 'Order',
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
    public function getCreateBy()
    {
        return $this->hasOne(User::className(), ['id' => 'create_by']);
    }
}
