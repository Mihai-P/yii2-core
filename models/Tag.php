<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "Tag".
 *
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property string $status
 * @property string $update_time
 * @property integer $update_by
 * @property string $create_time
 * @property integer $create_by
 *
 * @property ProductTag[] $productTags
 */
class Tag extends \core\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['status'], 'string'],
            [['update_time', 'create_time'], 'safe'],
            [['update_by', 'create_by'], 'integer'],
            [['name', 'type'], 'string', 'max' => 255]
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
            'type' => 'Type',
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
    public function getProductTags()
    {
        return $this->hasMany(ProductTag::className(), ['Tag_id' => 'id']);
    }
}
