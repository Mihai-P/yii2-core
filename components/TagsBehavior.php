<?php
/**
 * TagsBehaviour allows tag management to controllers
 *
 * @author Mihai Petrescu <mihai.petrescu@gmail.com>
 */
namespace core\components;

use Yii;
use yii\base\Behavior;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use core\models\Tag;
use yii\db\Expression;

/**
 * TagsBehaviour allows tag management to controllers
 *
 * For the controller define the following 2 functions
 *
 * ~~~
 * public function afterCreate($model) {
 *      $model->saveTags();
 *      return parent::afterCreate($model);
 * }
 *
 * public function afterUpdate($model) {
 *      $model->saveTags();
 *      return parent::afterCreate($model);
 * }
 * ~~~
 *
 * in the _form view at the top you should do a
 * $model->tags = $model->getTags();
 *
 * the model used should have a variable
 * var $tags;
 *
 * and a function that looks like
 * /**
 * @return \yii\db\ActiveQuery
 *   *\/
 * public function getModelTags()
 * {
 *      return $this->hasMany(Tag::className(), ['id' => 'Tag_id'])
 *          ->viaTable('Yyy_Tag', ['Yyy_id' => 'id'], function($query) {
 *              return $query->where('Yyy_Tag.status = "active"');
 *      });
 * }
 */
class TagsBehavior extends Behavior
{
    /**
     * @var string the type for the tag to be used
     */
    var $tagType;

    /**
     * Get the tags separated by ','. It uses the relation called modelTags from the model
     *
     * @return string
     */
    public function getTags() {
        return implode(",", array_keys(ArrayHelper::map($this->owner->getModelTags()->asArray()->all(), 'name', 'name')));
    }

    /**
     * Get the column name for the relation
     *
     * @return string
     */
    public function tagsOwnColumn() {
        return $this->owner->formName() . '_id';
    }
    /**
     * Get the name of the relationship table
     *
     * @return string
     */
    public function tagsRelationTable() {
        $model_name = $this->owner->formName();
        if($model_name > 'Tag') {
            $relationship_table = 'Tag_' . $model_name;
        } else {
            $relationship_table = $model_name . '_Tag';
        }
        return $relationship_table;
    }

    /**
     * Saves the tags om tje database
     *
     * @param bool $add if we should add the tags or replace the existing ones
     * @return null
     */
    public function saveTags($add = false)
    {
        $model_name = $this->owner->formName();
        $relationship_table = $this->tagsRelationTable();

        $own_column = $this->tagsOwnColumn();

        $this->tagType = $this->tagType ? $this->tagType : $model_name;
        if(isset($_POST[$model_name]['tags'])) {
            if($_POST[$model_name]['tags']) {
                $existing_ids = ['0'];
                foreach(explode(',',$_POST[$model_name]['tags']) as $tag_value) {
                    $tag = Tag::find()->where('status<>"deleted" AND name=:name AND type=:type', [':name' => $tag_value, ':type' => $this->tagType])->one();
                    if(!isset($tag->id)) {
                        $tag = new Tag;
                        $tag->type = $this->tagType;
                        $tag->name = $tag_value;
                        $tag->save();       
                    }
                    $existingRelation = (new Query())
                        ->from($relationship_table)
                        ->where("{$own_column} = :own_id AND Tag_id = :tag_id AND status='active'", [":own_id"=>$this->owner->id, ":tag_id"=>$tag->id])
                        ->one();
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
                        $insertedRelation = (new Query())
                            ->from($relationship_table)
                            ->where("{$own_column} = :own_id AND Tag_id = :tag_id AND status='active'", [":own_id"=>$this->owner->id, ":tag_id"=>$tag->id])
                            ->orderBy("id DESC")
                            ->one();
                        $existing_ids[] = $insertedRelation['id'];
                    }
                }
                if(!$add)
                    \Yii::$app->db->createCommand()->update($relationship_table, ['status' => "deleted", 'update_time' => new Expression('NOW()'), 'update_by' => Yii::$app->getUser()->id], "{$own_column} = " . $this->owner->id . " AND id NOT IN (" .implode(',', $existing_ids).")")->execute();
            } elseif(!$add) {
                \Yii::$app->db->createCommand()->update($relationship_table, ['status' => "deleted", 'update_time' => new Expression('NOW()'), 'update_by' => Yii::$app->getUser()->id], "{$own_column} = " . $this->owner->id)->execute();
            }
        }
    }       
}