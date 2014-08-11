<?php
namespace core\components;

use Yii;
use yii\base\Behavior;
use core\components\ActiveRecord;
use yii\helpers\ArrayHelper;
use core\models\Tag;
use yii\db\Expression;

class TagsBehavior extends Behavior
{
    var $tagType;

    public function afterFind() {
        $this->owner->tags = $this->getTags();
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags() {
        return implode(",", array_keys(ArrayHelper::map($this->owner->getModelTags()->asArray()->all(), 'name', 'name')));
    }

    public function tagsOwnColumn() {
        return $this->owner->formName() . '_id';
    }

    public function tagsRelationTable() {
        $model_name = $this->owner->formName();
        if($model_name > 'Tag') {
            $relationship_table = 'Tag_' . $model_name;
        } else {
            $relationship_table = $model_name . '_Tag';
        }
        return $relationship_table;
    }

    public function saveTags()
    {
        $model_name = $this->owner->formName();
        $relationship_table = $this->tagsRelationTable();

        $own_column = $this->tagsOwnColumn();

        $this->tagType = $this->tagType ? $this->tagType : $model_name;
        if(isset($_POST[$model_name]['tags'])) {
            if($_POST[$model_name]['tags']) {
                $existing_ids = array('0');
                foreach(explode(',',$_POST[$model_name]['tags']) as $tag_value) {
                    $tag = Tag::find()->where('status<>"deleted" AND name=:name AND type=:type', [':name' => $tag_value, ':type' => $this->tagType])->one();
                    if(!isset($tag->id)) {
                        $tag = new Tag;
                        $tag->type = $this->tagType;
                        $tag->name = $tag_value;
                        $tag->save();       
                    }
                    $existingRelation = (new \yii\db\Query())
                        ->from($relationship_table)
                        ->where("{$own_column} = :own_id AND Tag_id = :tag_id AND status='active'", [":own_id"=>$this->owner->id, ":tag_id"=>$tag->id])
                        ->one();
                    //find out if it is already inserted 
                    
                    if($existingRelation) {
                        $existing_ids[] = $existingRelation['id'];
                    } else {
                        \Yii::$app->db->createCommand()->insert($relationship_table, [
                            'Tag_id' => $tag->id,
                            $own_column => $this->owner->id,
                            'update_by' => Yii::$app->getUser()->id,
                            'create_by' => Yii::$app->getUser()->id,
                            'update_time' => new Expression('NOW()'),
                            'create_time' => new Expression('NOW()'),
                        ])->execute();
                        /*
                        $sql = (new \yii\db\QueryBuilder(\Yii::$app->db))->insert($relationship_table, [
                            'Tag_id' => $tag->id,
                            $own_column => $this->owner->id,
                            'update_by' => Yii::$app->getUser()->id,
                            'create_by' => Yii::$app->getUser()->id,
                        ], [])->execute();*/
                        $insertedRelation = (new \yii\db\Query())
                            ->from($relationship_table)
                            ->where("{$own_column} = :own_id AND Tag_id = :tag_id AND status='active'", [":own_id"=>$this->owner->id, ":tag_id"=>$tag->id])
                            ->orderBy("id DESC")
                            ->one();
                        $existing_ids[] = $insertedRelation['id'];
                    }
                }
                \Yii::$app->db->createCommand()->update($relationship_table, ['status' => "deleted", 'update_time' => new Expression('NOW()'), 'update_by' => Yii::$app->getUser()->id], "{$own_column} = " . $this->owner->id . " AND id NOT IN (" .implode(',', $existing_ids).")")->execute();
                /*Yii::app()->db->createCommand("UPDATE {$relationship_table} SET status = 'deleted', update_time = NOW(), update_by = :user_id WHERE {$own_column} = :own_id AND id NOT IN (" .implode(',', $existing_ids).")")->execute(array(":own_id"=>$this->owner->id, ":user_id"=>Yii::app()->user->getId()));*/
            } else {
                \Yii::$app->db->createCommand()->update($relationship_table, ['status' => "deleted", 'update_time' => new Expression('NOW()'), 'update_by' => Yii::$app->getUser()->id], "{$own_column} = " . $this->owner->id)->execute();
            }
        }
    }       
}