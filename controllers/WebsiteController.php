<?php

namespace core\controllers;

use Yii;
use core\components\Controller;

/**
 * WebsiteController implements the CRUD actions for Website model.
 */
class WebsiteController extends Controller
{
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
        $this->layout = '//form';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->saveHistory($model);
            Yii::$app->getSession()->setFlash('success', 'The changes have been saved.');
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }    
}