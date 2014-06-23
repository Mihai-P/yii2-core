<?php

namespace core\components;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
/**
 * FaqController implements the CRUD actions for Faq model.
 */
class Controller extends \yii\web\Controller
{
    var $MainModel = '';
    var $MainModelSearch = '';
    /**
     * Lists all Faq models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = '//table';
        $searchModel = new $this->MainModelSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(!Yii::$app->session->get($this->MainModel.'Pagination')) {
            Yii::$app->session->set($this->MainModel.'Pagination', 10);
        }
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Faq models.
     * @return mixed
     */
    public function actionPagination()
    {
        Yii::$app->session->set($this->MainModel.'Pagination',Yii::$app->request->queryParams['records']);
        $this->redirect( ['index'] );
    }

    /**
     * Displays a single Faq model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = '//form';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Faq model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = '//form';
        $model = new $this->MainModel;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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
        $this->layout = '//form';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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
    public function actionStatus($id)
    {
        $model = $this->findModel($id);
        if($model->status == "active") {
            $model->status = "inactive";
        } else {
            $model->status = "active";
        }
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Faq model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Faq model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Faq the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = call_user_func_array(array($this->MainModel, 'findOne'), array($id));
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}