<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "Group".
 *
 * @property integer $id
 * @property string $name
 * @property string $status
 * @property string $update_time
 * @property string $update_by
 * @property string $create_time
 * @property string $create_by
 *
 * @property User[] $users
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['update_time', 'create_time'], 'safe'],
            [['name', 'status', 'update_by', 'create_by'], 'string', 'max' => 255]
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
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['Group_id' => 'id']);
    }
}
