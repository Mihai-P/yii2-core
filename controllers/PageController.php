<?php

namespace core\controllers;

use Yii;
use core\components\Controller;
use core\models\Object;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller
{
    var $MainModel = 'core\models\Page';
    var $MainModelSearch = 'core\models\PageSearch';

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' or 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = static::FORM_LAYOUT;
        $model = new $this->MainModel;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->afterCreate($model);
            if(count(Yii::$app->getModule('core')->pageTemplates) >1) {
                return $this->redirect(['update', 'id' => $model->id]);
            } elseif ($this->hasView)
                return $this->redirect(['view', 'id' => $model->id]);
            else
                return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function afterCreate($model) {
    	$model->saveObjects();
        parent::afterCreate($model);
    }

    public function afterUpdate($model) {
        $model->saveObjects();
        parent::afterUpdate($model);
    }    
}