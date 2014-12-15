<?php

namespace core\models;

use Yii;
use \core\components\ActiveRecord;
/**
 * This is the model class for table "History".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $status
 * @property string $update_time
 * @property integer $update_by
 * @property string $create_time
 * @property integer $create_by
 *
 * @property User $createBy
 */
class History extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'History';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'type'], 'required'],
            [['status', 'type'], 'string'],
            [['update_time', 'create_time'], 'safe'],
            [['update_by', 'create_by'], 'integer'],
            [['name', 'url'], 'string', 'max' => 255]
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
