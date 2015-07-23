<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "Note".
 *
 * @property integer $id
 * @property string $Model
 * @property integer $Model_id
 * @property string $description
 * @property string $status
 * @property string $update_time
 * @property integer $update_by
 * @property string $create_time
 * @property integer $create_by
 */
class Note extends \core\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Note';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Model', 'Model_id'], 'required'],
            [['Model_id', 'update_by', 'create_by'], 'integer'],
            [['update_time', 'create_time'], 'safe'],
            [['Model', 'description', 'status'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Model' => 'Model',
            'Model_id' => 'Model',
            'description' => 'Description',
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
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'update_by']);
    }
}
