<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace core\components;

use Yii;
use yii\base\Action;


/**
 * SaveAction saves a model that may or may not exist.
 *
 * To use SaveAction, you need to do the following steps:
 *
 * First, declare an action of SaveAction type in the `actions()` method of your `NameController`
 * class (or whatever controller you prefer), like the following:
 *
 * ```php
 * public function actions()
 * {
 *     return [
 *         'details' => ['class' => 'core\components\SaveAction'],
 *     ];
 * }
 * ```
 *
 * @author Mihai Petrescu <mihai.petrescu@gmail.com>
 */
class SaveAction extends Action
{
    public function run()
    {
        $post = Yii::$app->request->post();

        $model = new $this->controller->MainModel;
        $id = isset($post[$model->formName()]['id']) ? $post[$model->formName()]['id'] : false;
        if($id) {
            $model = $this->controller->findModel($id);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (Yii::$app->request->getIsAjax()) {
                Yii::$app->response->format = 'json';
                return ['success' => true, 'id' => $model->id];
            }
            if ($this->controller->hasView)
                return $this->controller->redirect(['view', 'id' => $model->id]);
            else
                return $this->controller->redirect(['index']);
        } else {
            return $this->controller->redirect(['create']);
        }
    }
}
