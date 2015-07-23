<?php

namespace core\controllers;

use Yii;
use core\models\Note;
use yii\filters\AccessControl;

/**
 * NoteController implements the CRUD actions for Note model.
 */
class NoteController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['save'], // Define specific actions
                        'allow' => true, // Has access
                        'roles' => ['@'], // Guests '?'
                    ],
                ],
            ],
        ];
    }

    /**
     * Saves a model.
     * If creation is successful, the browser will be redirected to the 'view' or 'index' page.
     * @return mixed
     */
    public function actionSave()
    {
        $post = Yii::$app->request->post();
        $id = $post['Note']['id'];
        if($id) {
            $model = Note::findOne($id);
        } else {
            $model = new Note;
        }
        Yii::$app->response->format = 'json';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'errors' => $model->getErrors()];
        }
    }
}