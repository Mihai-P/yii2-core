<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "Notification".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $start_date
 * @property string $end_date
 * @property string $internal_type
 * @property string $type
 * @property string $all
 * @property string $status
 * @property string $update_time
 * @property integer $update_by
 * @property string $create_time
 * @property integer $create_by
 *
 * @property NotificationRead[] $notificationReads
 * @property NotificationUser[] $notificationUsers
 */
class Notification extends \core\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'all'], 'required'],
            [['description'], 'string'],
            [['start_date', 'end_date', 'update_time', 'create_time'], 'safe'],
            [['update_by', 'create_by'], 'integer'],
            [['name', 'internal_type', 'type', 'all', 'status'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'internal_type' => 'Internal Type',
            'type' => 'Type',
            'all' => 'All',
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
    public function getNotificationReads()
    {
        return $this->hasMany(NotificationRead::className(), ['Notification_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotificationUsers()
    {
        return $this->hasMany(NotificationUser::className(), ['Notification_id' => 'id']);
    }
}
