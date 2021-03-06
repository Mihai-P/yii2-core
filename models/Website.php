<?php

namespace core\models;

use Yii;
use yii\helpers\ArrayHelper;
use core\components\ObjectsBehavior;
use core\components\SeoBehavior;
use core\components\ActiveRecord;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "Website".
 *
 * @property integer $id
 * @property string $name
 * @property string $host
 * @property string $theme
 * @property string $template 
 * @property string $status
 * @property string $update_time
 * @property integer $update_by
 * @property string $create_time
 * @property integer $create_by
 */
class Website extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Website';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'host', 'theme', 'template'], 'string'],
            [['update_time', 'create_time'], 'safe'],
            [['update_by', 'create_by'], 'integer'],
            [['name', 'host', 'theme', 'template'], 'string', 'max' => 255]
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
            'host' => 'Host',
            'theme' => 'Theme',
            'template' => 'Template',
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
                'objects' => [
                    'class' => ObjectsBehavior::className(),
                ],
                'seo' => [
                    'class' => SeoBehavior::className(),
                ],
            ],
            parent::behaviors()
        );
    }

    /**
     * get the details of a website
     * @return Website
     */
    public static function details()
    {
        return self::find()->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeo()
    {
        return $this->hasOne(Seo::className(), ['Model_id' => 'id'])->where('Model = :Model', [':Model' => StringHelper::basename(get_class($this))]);
    }
}
