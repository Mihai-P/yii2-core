<?php

namespace core\controllers;

use Yii;
use core\components\Controller;

/**
 * WebsiteController implements the CRUD actions for Website model.
 */
class WebsiteController extends Controller
{
    var $hasView = true;
    var $MainModel = 'core\models\Website';
    var $MainModelSearch = 'core\models\WebsiteSearch';

    /**
     * Updates an existing Faq model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = static::MAIN_LAYOUT;
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->afterUpdate($model);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            if($model->template) {
                return $this->render($model->template, [
                    'model' => $model,
                ]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
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