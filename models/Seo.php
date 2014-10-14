<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "Seo".
 *
 * @property integer $id
 * @property string $Model
 * @property integer $Model_id
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $status
 * @property string $update_time
 * @property integer $update_by
 * @property string $create_time
 * @property integer $create_by
 */
class Seo extends \core\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Seo';
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
            [['Model', 'meta_title', 'meta_keywords', 'meta_description', 'status'], 'string', 'max' => 255]
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
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'status' => 'Status',
            'update_time' => 'Update Time',
            'update_by' => 'Update By',
            'create_time' => 'Create Time',
            'create_by' => 'Create By',
        ];
    }
}
