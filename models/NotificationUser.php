<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "NotificationUser".
 *
 * @property integer $id
 * @property integer $Notification_id
 * @property integer $User_id
 * @property string $status
 * @property string $update_time
 * @property integer $update_by
 * @property string $create_time
 * @property integer $create_by
 *
 * @property User $user
 * @property Notification $notification
 */
class NotificationUser extends \core\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'NotificationUser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Notification_id', 'User_id'], 'required'],
            [['Notification_id', 'User_id', 'update_by', 'create_by'], 'integer'],
            [['update_time', 'create_time'], 'safe'],
            [['status'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Notification_id' => 'Notification',
            'User_id' => 'User',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'User_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotification()
    {
        return $this->hasOne(Notification::className(), ['id' => 'Notification_id']);
    }
}
