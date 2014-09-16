<?php
namespace core\components;

use Yii;
use yii\base\Behavior;
use core\components\ActiveRecord;
use core\models\Object;

class ObjectsBehavior extends Behavior
{
    public function short_model($model)
    {
        $model = $this->owner;
        $url_components = explode("\\", get_class($model));
        return $url_components[2];
    }


    public function getObjects()
    {
        return $this->owner->hasMany(Object::className(), ['Model_id' => 'id'])->where('Model = :Model', [':Model' => $this->short_model($this->owner)]);
    }

    public function object($name)
    {
        $objects = Yii::$app->cache->get(get_class($this->owner) . $this->owner->id);

        if ($objects === false) {
            $objectModels = $this->owner->objects;
            foreach($objectModels as $objectModel) {
                $objects[$objectModel['name']] = $objectModel;
            }
            Yii::$app->cache->set(get_class($this->owner) . $this->owner->id, $objects);
        }
        if(isset($objects[$name])) {
            return $objects[$name];
        }
        $object = new Object;
        $object->name = $name;
        return $object;
    }

    public function saveObjects()
    {
        $post = Yii::$app->request->post();
        $model = $this->owner;
        $url_components = explode("\\", get_class($model));
        $model_name = $url_components[2];

        if(isset($post['Object'])) {
            foreach($post['Object'] as $name => $content) {
                $object = Object::find()->where('Model = :Model and Model_id = :Model_id and name = :name', [':Model'=>$model_name, ':Model_id'=>$model->id, ':name'=>$name])->one();
                if(!$object) {
                    $object = new Object;
                    $object->name = $name;
                    $object->Model = $model_name;
                    $object->Model_id = $model->id;
                }
                $object->content = $content;
                $object->save();
            }
        }
        Yii::$app->cache->delete(get_class($this->owner) . $this->owner->id);
    }
}