<?php

namespace core\models;

use Yii;
use core\components\DefaultQuery;
use \core\components\ActiveRecord;

/**
 * This is the model class for table "AdminMenu".
 *
 * @property integer $id
 * @property integer $AdminMenu_id
 * @property string $name
 * @property string $internal
 * @property string $url
 * @property string $ap
 * @property integer $order
 * @property string $show_mobile
 * @property string $status
 * @property string $update_time
 * @property integer $update_by
 * @property string $create_time
 * @property integer $create_by
 *
 * @property AdminMenu $adminMenu
 * @property AdminMenu[] $adminMenus
 */
class AdminMenu extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'AdminMenu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['AdminMenu_id', 'order', 'update_by', 'create_by'], 'integer'],
            [['name', 'internal', 'order'], 'required'],
            [['ap', 'show_mobile', 'status'], 'string'],
            [['update_time', 'create_time'], 'safe'],
            [['name', 'internal', 'url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     * @return DefaultQuery
     */
    public static function find()
    {
        return new DefaultQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminMenu()
    {
        return $this->hasOne(AdminMenu::className(), ['id' => 'AdminMenu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminMenus()
    {
        return $this->hasMany(AdminMenu::className(), ['AdminMenu_id' => 'id'])->orderby('order ASC');
    }
}
