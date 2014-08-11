<?php

namespace core\controllers;

use Yii;
use core\components\Controller;
use core\models\Menu;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
{
    var $MainModel = 'core\models\Menu';
    var $MainModelSearch = 'core\models\MenuSearch';

    /**
     * Deletes an existing Faq model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionStatus($id)
    {
        $model = $this->findModel($id);
        if($model->status == "active") {
            $model->status = "inactive";
        } else {
            $model->status = "active";
        }
        $model->saveNode(false);
        if(Yii::$app->request->getIsAjax()) {
            Yii::$app->response->format = 'json';
            return ['success' => true];
        } else {
            return $this->redirect(['index']);
        }
    }    


    /**
     * Creates a new Faq model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = static::FORM_LAYOUT;
        $model = new $this->MainModel;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if(empty($model->Menu_id)) {
                $model->saveNode();
            } else {
                $parent_node = Menu::findOne($model->Menu_id);
                $model->appendTo($parent_node);
            }
            $this->saveHistory($model, $this->historyField);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Faq model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = static::FORM_LAYOUT;
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $current_model = $this->findModel($id);
            if($current_model->Menu_id != $model->Menu_id){
                $parent_node = Menu::findOne($model->Menu_id);
                $model->saveNode(false);
                $model->moveAsLast($parent_node);
            } else {
                $model->saveNode(false);
            }

            $this->saveHistory($model, $this->historyField);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Deletes an existing Faq model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteNode();
        if(Yii::$app->request->getIsAjax()) {
            \Yii::$app->response->format = 'json';
            return ['success' => true];
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Deletes a list of models
     * @return mixed
     */
    public function actionDeleteAll()
    {
        if(isset($_POST['items'])) {
            foreach($_POST['items'] as $id) {
                $this->findModel($id)->deleteNode();
            }
        }
    }
}