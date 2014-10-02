<?php

namespace core\controllers;

use Yii;
use core\components\Controller;
use yii\helpers\ArrayHelper;
use core\models\Tag;
use yii\db\Expression;

/**
 * ContactController implements the CRUD actions for Contact model.
 */
class ContactController extends Controller
{
    var $MainModel = 'core\models\Contact';
    var $MainModelSearch = 'core\models\ContactSearch';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
            [
                'access' => [
                    'rules' => [
                        [
                            'actions' => ['assign-tags'], // Define specific actions
                            'allow' => true, // Has access
                            'roles' => ['update::' . $this->getCompatibilityId()],
                        ],
                    ],
                ],
            ],
            parent::behaviors()
        );
    }

    /**
     * Sets the bulk actions that can be performed on the table of models
     * @param string $grid the ID of the grid that will be updated
     * @return array
     */
    public function allButtons($grid ='')
    {
        $buttons = parent::allButtons($grid);
        if(\Yii::$app->user->checkAccess('read::' . $this->getCompatibilityId())) {
            $buttons['tag'] = [
                'text' => 'Assign to tag', 
                'url' => '#assign-all-tag', 
                'options' => [
                    'data-toggle' => "modal",
                    'data-pjax' => 0,
                    'role' => "button",
                ]
            ];
        }
        return $buttons;
    }

    public function afterCreate($model) {
        $model->saveTags();
        return parent::afterCreate($model);
    }

    public function afterUpdate($model) {
        $model->saveTags();
        return parent::afterCreate($model);
    }

    /**
     * Activates a list of models
     * @return mixed
     */
    public function actionAssignTags()
    {
        foreach(explode(',',$_POST['Contact']['tags']) as $tag_value) {
            $tag = Tag::find()->where('status<>"deleted" AND name=:name AND type=:type', [':name' => $tag_value, ':type' => 'Contact'])->one();
            if(!isset($tag->id)) {
                $tag = new Tag;
                $tag->type = 'Contact';
                $tag->name = $tag_value;
                $tag->save();       
            }
            $tagList[] = $tag->id;
        }

        $this->getSearchCriteria();
        $this->dataProvider->pagination = false;

        $result = $this->dataProvider->query->select('id')->asArray()->all();

        foreach($result as $model) {
            foreach ($tagList as $tag_id) {
                $insert[] = '(' . $tag_id . ',' . $model['id'] . ',NOW(),NOW(),' . Yii::$app->user->identity->id . ',' . Yii::$app->user->identity->id . ')';
            }
        }
        // INSERT multiple rows at once
        \Yii::$app->db->createCommand("INSERT IGNORE INTO Contact_Tag (Tag_id, Contact_id, update_time, create_time, update_by, create_by) VALUES ".implode(',',$insert))->execute();
        return $this->redirect(['index']);
    }    
}