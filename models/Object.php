<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "Object".
 *
 * @property integer $id
 * @property string $Model
 * @property integer $Model_id
 * @property string $name
 * @property string $content
 * @property string $required
 * @property string $status
 * @property string $update_time
 * @property integer $update_by
 * @property string $create_time
 * @property integer $create_by
 */
class Object extends \core\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Object';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Model', 'Model_id', 'name'], 'required'],
            [['Model_id', 'update_by', 'create_by'], 'integer'],
            [['content', 'required', 'status'], 'string'],
            [['update_time', 'create_time'], 'safe'],
            [['Model', 'name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'content' => $this->name,
        ];
    }
}
