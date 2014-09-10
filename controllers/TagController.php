<?php

namespace core\controllers;

use Yii;
use core\components\Controller;
use core\models\Tag;
use yii\helpers\ArrayHelper;

/**
 * TagController implements the CRUD actions for Tag model.
 */
class TagController extends Controller
{
    var $MainModel = 'core\models\Tag';
    var $MainModelSearch = 'core\models\TagSearch';

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
	                        'actions' => ['list'], // Define specific actions
	                        'allow' => true, // Has access
	                        'roles' => ['read::' . $this->getCompatibilityId()],
	                    ],
	                ],
	           	],
	        ],
			parent::behaviors()
		);
    }

    /**
     * Updates the prices of a product
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionList($type, $term)
    {
    	$tags = Tag::find()->where('type = :type AND LOWER(name) LIKE :term AND status<>"deleted"', [':type' => $type, ':term' => '%' . strtolower($term) . '%'])->all();
    	$response = [];
    	foreach($tags as $tag) {
    		$response[] = ["id" => $tag->id, "label" => $tag->name, "value" => $tag->name];
    	}
        Yii::$app->response->format = 'json';
        return $response;
    }
}