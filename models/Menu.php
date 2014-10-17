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
 * @property string $responsive
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
            [['name', 'rel', 'responsive', 'target', 'ap', 'internal', 'url'], 'string', 'max' => 255]
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
            'responsive' => 'Responsive',
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

    /**
     * Global responsive options that will be used for the responsive dropdown
     *
     * @return array
     */
    public static function responsiveOptions()
    {
        return [
            '' => 'Always visible',
            'hidden-xs' => 'Hidden on small phones',
            'hidden-xs hidden-sm' => 'Hidden on small phones and small tablets',
            'hidden-xs hidden-sm hidden-md' => 'Hidden on small phones and small tablets and medium desktops',
            'visible-xs-{type}' => 'Visible only on small phones',
            'visible-xs-{type} visible-sm-{type}' => 'Visible only on small phones and small tablets',
            'visible-xs-{type} visible-sm-{type} hidden-md-{type}' => 'Visible only on small phones and small tablets and medium desktops',
        ];
    }

    /**
     * Global rel options that will be used for the Rel dropdown
     *
     * @return array
     */
    public static function relOptions()
    {
        return [
            '' => '',
            'alternate' => 'alternate - Links to an alternate version of the document (i.e. print page, translated or mirror)',
            'author' => 'author - Links to the author of the document',
            'bookmark' => 'bookmark - Permanent URL used for bookmarking',
            'help' => 'help - Links to a help document',
            'license' => 'license - Links to copyright information for the document',
            'next' => 'next - The next document in a selection',
            'nofollow' => 'nofollow - Links to an unendorsed document, like a paid link.',
            'noreferrer' => 'noreferrer - Specifies that the browser should not send a HTTP referer header if the user follows the hyperlink',
            'prefetch' => 'prefetch - Specifies that the target document should be cached',
            'prev' => 'prev - The previous document in a selection',
            'search' => 'search - Links to a search tool for the document',
            'tag' => 'tag - A tag (keyword) for the current document',
        ];
    }

    /**
     * Global target options that will be used for the Target dropdown
     *
     * @return array
     */
    public static function targetOptions()
    {
        return [
            '' => '',
            '_blank' => 'Opens the linked document in a new window or tab',
            '_self' => 'Opens the linked document in the same frame as it was clicked (this is default)',
            '_parent' => 'Opens the linked document in the parent frame',
            '_top' => 'Opens the linked document in the full body of the window',
        ];
    }

}