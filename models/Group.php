<?php

namespace core\models;

use Yii;
use core\models\AuthItem;

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
class Group extends \core\components\ActiveRecord
{
    var $privileges;
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
            [['name'], 'required'],
            [['update_time', 'create_time', 'privileges'], 'safe'],
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

    public function afterFind()
    {

        $roles = Yii::$app->authManager->getChildren($this->id);
        $this->privileges = array_keys($roles);
        parent::afterFind();
    }

    public function afterSave()
    {
        $auth = Yii::$app->authManager;
        $post = Yii::$app->request->post();
        if(isset($post['Group']['privileges'])) {
            $this->privileges = $post['Group']['privileges'];
            
            $auth_item = AuthItem::find()->where('name = :name' , array(':name' => $this->id))->one();

            if ($this->isNewRecord || !isset($auth_item->name)) {
                $role=$auth->createRole($this->id);
                $auth->add($role);
            } else {
                $role=$auth->getRole($this->id);
            }
            
            if(isset($role)) {
                if(isset($this->privileges)) {
                    $item_children = $auth->getChildren($this->id);
                    if(count($item_children)) {
                        foreach($item_children as $item_child) {
                            $auth->removeChild($role, $item_child);
                        }
                    }
                    
                    if(is_array($this->privileges) && count($this->privileges)) {
                        foreach($this->privileges as $value) {
                            $assignment_role = AuthItem::find()->where('name = :name' , array(':name' => $value))->one();
                            if(!$auth->hasChild($role, $assignment_role))
                                $auth->addChild($role, $assignment_role);
                        }
                    }               
                }
            }
        }
    }    
}
