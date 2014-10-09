<?php

namespace core\models;

use Yii;
use core\components\CategoryQuery;
use creocoder\behaviors\NestedSet;
use yii\helpers\ArrayHelper;
use core\components\ActiveRecord;

/**
 * This is the model class for table "Menu".
 *
 * @property integer $id
 * @property integer $Menu_id
 * @property string $name
 * @property string $internal
 * @property string $url
 * @property string $rel
 * @property string $target
 * @property string $ap
 * @property integer $order
 * @property string $root
 * @property string $lft
 * @property string $rgt
 * @property string $level
 * @property string $status
 * @property string $update_time
 * @property integer $update_by
 * @property string $create_time
 * @property integer $create_by
 *
 * @property Menu $menu
 * @property Menu[] $menus
 */
class Menu extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Menu_id', 'order', 'root', 'lft', 'rgt', 'level', 'update_by', 'create_by'], 'integer'],
            [['name'], 'required'],
            [['status'], 'string'],
            [['update_time', 'create_time'], 'safe'],
            [['name', 'rel', 'target', 'ap', 'internal', 'url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Menu_id' => 'Parent',
            'name' => 'Name',
            'internal' => 'Internal',
            'url' => 'Url',
            'rel' => 'Rel',
            'target' => 'Target',
            'ap' => 'Ap',
            'order' => 'Order',
            'root' => 'Root',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'level' => 'Level',
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
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'Menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['Menu_id' => 'id']);
    }

    public function behaviors()
    {
        return ArrayHelper::merge(
            [
                'nestedSet' => [
                    'class' => NestedSet::className(),
                    'hasManyRoots' => true
                ]
            ],
            parent::behaviors()
        );
    }
    
    public static function createQuery()
    {
        return new CategoryQuery(['modelClass' => get_called_class()]);
    }        
}